<?php

namespace Drupal\degov_tweets\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\degov_tweets\TwitterAPIExchange;

/**
 * Provides a 'TwitterBlock' block.
 *
 * @Block(
 *  id = "degov_twitter_block",
 *  admin_label = @Translation("Twitter block"),
 * )
 */
class TwitterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['markup'] = [
      '#type' => 'markup',
      '#markup' => t('<a href="@url">Create a twitter app on the twitter developer site</a>', ['@url' => 'https://dev.twitter.com/apps/']),
    ];
    $form['tweets_username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Twitter username'),
      '#default_value' => isset($this->configuration['tweets_username']) ? $this->configuration['tweets_username'] : 'deGov',
    ];
    $form['tweets_limit'] = [
      '#type' => 'number',
      '#title' => $this->t('Limit'),
      '#default_value' => isset($this->configuration['tweets_limit']) ? $this->configuration['tweets_limit'] : 12,
    ];
    $form['tweets_update_every'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Update every'),
      '#description' => $this->t('Set the number in seconds. E.g. 3600 = 1 hour'),
      '#default_value' => isset($this->configuration['tweets_update_every']) ? $this->configuration['tweets_update_every'] : 7200,
    ];
    $form['access_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Access token'),
      '#default_value' => isset($this->configuration['access_token']) ? $this->configuration['access_token'] : '',
    ];
    $form['token_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Token secret'),
      '#default_value' => isset($this->configuration['token_secret']) ? $this->configuration['token_secret'] : '',
    ];
    $form['consumer_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Consumer key'),
      '#default_value' => isset($this->configuration['consumer_key']) ? $this->configuration['consumer_key'] : '',
    ];
    $form['consumer_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Consumer secret'),
      '#default_value' => isset($this->configuration['consumer_secret']) ? $this->configuration['consumer_secret'] : '',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['access_token'] = $form_state->getValue('access_token');
    $this->configuration['token_secret'] = $form_state->getValue('token_secret');
    $this->configuration['consumer_key'] = $form_state->getValue('consumer_key');
    $this->configuration['consumer_secret'] = $form_state->getValue('consumer_secret');
    $this->configuration['tweets_username'] = $form_state->getValue('tweets_username');
    $this->configuration['tweets_limit'] = $form_state->getValue('tweets_limit');
    $this->configuration['tweets_update_every'] = $form_state->getValue('tweets_update_every');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    // Make a request to Twitter API.
    $settings = [
      'oauth_access_token' => $this->configuration['access_token'],
      'oauth_access_token_secret' => $this->configuration['token_secret'],
      'consumer_key' => $this->configuration['consumer_key'],
      'consumer_secret' => $this->configuration['consumer_secret'],
    ];
    $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name=' . $this->configuration['tweets_username'] . '&count=' . $this->configuration['tweets_limit'];
    $requestMethod = 'GET';

    $twitter = new TwitterAPIExchange($settings);
    $response = $twitter->setGetfield($getfield)
      ->buildOauth($url, $requestMethod)
      ->performRequest();

    if ($response) {
      $tweets = json_decode($response);
      $build = [
        '#theme' => 'degov_tweets',
        '#tweets' => $tweets,
        '#cache' => [
          'max-age' => $this->configuration['tweets_update_every'],
        ],
      ];
    }
    return $build;
  }

}
