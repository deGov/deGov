<?php

namespace Behat\Features\Context;


use Behat\Behat\Context\TranslatableContext;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Drupal\DrupalExtension\Context\RawDrupalContext;
use Symfony\Component\Validator\Constraints\IsTrue;
use Behat\MinkExtension\Context\MinkContext;

class DeGovContext  extends RawDrupalContext implements TranslatableContext {

  /**
   * Returns array of Translator-supported resource paths.
   *
   * For instance:
   *
   *  * array(__DIR__.'/../'ru.yml)
   *  * array(__DIR__.'/../'en.xliff)
   *  * array(__DIR__.'/../'de.php)
   *
   * @return string[]
   */
  public static function getTranslationResources() {
    return glob(__DIR__ . '/../../../vendor/drupal/drupal-extension/i18n/*.xliff');
  }

  /**
   * @Then the :arg1 radiobutton should be selected
   */
  public function theRadiobuttonShouldBeSelected($arg1)
  {
    $this->assertSession()->checkboxChecked($arg1);
  }

  /**
   * @Then the :arg1 radiobutton should not be selected
   */
  public function theRadiobuttonShouldNotBeSelected($arg1)
  {
    $this->assertSession()->checkboxNotChecked($arg1);
  }

  /**
   * Taken from lightning.behat.inc
   * Clicks an arbitrary element, found by CSS selector.
   *
   * @param string $selector
   *   The CSS selector.
   *
   * @throws \Behat\Mink\Exception\ElementNotFoundException
   *   If the specified element is not present on the page.
   *
   * @When I click the :selector element
   */
  public function clickElementBySelector($selector) {
    $session = $this->getSession();
    $element = $session->getPage()->find('css', $selector);
    if ($element) {
      $element->click();
    }
    else {
      throw new ElementNotFoundException($session, 'element', 'css', $selector);
    }
  }


  /**
   * @Given /^I resize the window to "([^"]*)" x "([^"]*)"$/
   *
   * Courtesy of http://www.devengineering.com/blog/user-insights/resize-or-maximize-browser-window-behatminkdrupal
   */
  public function iSetBrowserWindowSizeToX($width, $height) {
    $this->getSession()->resizeWindow((int)$width, (int)$height, 'current');
  }

    /**
     * @When I click on :arg1 with selector :arg2
     */
    public function iClickOn($arg1, $arg2)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find('css', $arg2);
        if ($element) {
            $element->click();
        }
        else {
            throw new ElementNotFoundException($session, 'element', 'css', $arg2);
        }
    }

    /**
     * @Then I click a link :arg1 with selector :arg2
     */
    public function iClickALinkWithSelector($arg1, $arg2)

    {

        $session = $this->getSession();
        $element = $session->getPage()->find('css', $arg2);
        print_r($element);
        throw new PendingException();
    }

    /**
     * @Then I wait for :arg1 seconds
     */
    public function iWaitForSeconds($arg1)
    {
        sleep(10);
        return;
    }
    /**
     * Click some text
     *
     * @When /^I click on the text "([^"]*)"$/
     */
    public function iClickOnTheText($text)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'xpath',
            $session->getSelectorsHandler()->selectorToXpath('xpath', '*//*[text()="'. $text .'"]')
        );
        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Cannot find text: "%s"', $text));
        }

        $element->click();

    }


}
