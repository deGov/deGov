<?php


namespace Drupal\itnrw_map\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Description of ItnrwMap, based of
 * Geocoding REST Service: Geo-kodierungsdienst für Adressen und Geonamen (GeoBasis-DE) Version 1.2 (29.07.2015)
 * @author Raul Garcia
 */
class ItnrwMapController extends ControllerBase{

  protected $url = "";
  protected $token = "";

  /**
   * ItnrwMap constructor.
   * @param string $token
   */
  public function __construct($token = "") {

    $this->token = $token ?: "dcc283ec-e666-069b-42f0-160b2cfa13d6";
    $this->url = "http://sg.geodatenzentrum.de/gdz_geokodierung__$token/geosearch?";

  }

  /**
   * Geocodes an address and returns the coordinates
   * @param string $address
   * @return string formatted string to pass to map
   */
  public function geocodeAddress($address) {

    $geocoded = array();

    $query_string = $this->url . 'outputformat=json&srsName=EPSG:32632&query=' . urlencode($address). '&filter=bundesland:Nordrhein-Westfalen';

    $query_url_encoded = preg_replace('/\ /', '%20', preg_replace('/\"/', '%22', $query_string));

    $response_json = $this->curlGetPageShort($query_url_encoded);
    $response = json_decode($response_json, false);

    if (!isset($response->error)) {
      $geocoded = $this->getCoordinatesFromGeocoder($response);
    }else{
      \Drupal::logger('itnrw_map')->error(__FUNCTION__ . ": Error %variable",
        array(
          '%variable'=> $response->error
        ));

    }
    if (!$geocoded) {
      $geocoded = array('geo_x' => NULL, 'geo_y' => NULL);
      $geocoded['address'] = "";

      \Drupal::logger('itnrw_map')->error(__FUNCTION__ . ": Address %address not found",
          array(
            '%address' => $address
          ));
    }

    return $this->formatOutput($geocoded);
  }

  private function getCoordinatesFromGeocoder($response) {
    $geocoded = array();
    if (isset($response->features[0]->geometry->coordinates)) {
      $geocoded = array('geo_x' => $response->features[0]->geometry->coordinates[0], 'geo_y' => $response->features[0]->geometry->coordinates[1]);
    }
    if (isset($response->features[0]->properties->text)) {
      $geocoded['address'] = $response->features[0]->properties->text;
    }

    return $geocoded;
  }

  /**
   * Calls an URL with cURL (Short format)
   *
   * @param  string $urlString
   * @return  string the web page
   */
  public function curlGetPageShort($urlString) {

    $url = strtr($urlString, array('&amp;' => '&'));

    $curlShort = curl_init();
    curl_setopt($curlShort, CURLOPT_URL, $url);
    curl_setopt($curlShort, CURLOPT_HEADER, array());
    curl_setopt($curlShort, CURLOPT_POST, FALSE);
    curl_setopt($curlShort, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($curlShort, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curlShort, CURLOPT_SSL_VERIFYPEER, FALSE);  // this line makes it work under https

    $result = curl_exec($curlShort);
    if (!$result) {
      $errNum = curl_errno($curlShort);
      \Drupal::logger('itnrw_map')->error(__FUNCTION__ . ": Error %error_num in cURL: %error",
        array('%error_num' => $errNum,
              '%error' => curl_error($curlShort)
        ));
      return FALSE;
    }
    curl_close($curlShort);
    return $result;
  }

  /**
   * Returns a formatted address for the map using coordinates
   * @param array $data Array with geo_x, geo_y adn address in fomt street number, zip city
   * @return string $output
   */
  function formatOutput($data) {

    $sAddress = $data['address'];
    $coords = $data['geo_x'] . "," . $data['geo_y'];

    return "[epsg:25832;$coords;$sAddress;;;]";
  }

}
