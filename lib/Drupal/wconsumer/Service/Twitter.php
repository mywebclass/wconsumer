<?php
namespace Drupal\wconsumer\Service;

use Drupal\wconsumer\Authentication\Oauth\Oauth;



class Twitter extends Service {
  protected $name = 'twitter';
  protected $apiUrl = 'https://api.twitter.com/1.1/';



  public function getMeta() {
    $meta = parent::getMeta();
    $meta->registerAppUrl = 'https://dev.twitter.com/apps/new';
    return $meta;
  }

  protected function initAuthentication() {
    $auth = new Oauth($this);

    $auth->requestTokenUrl  = 'https://api.twitter.com/oauth/request_token';
    $auth->authorizeUrl     = 'https://api.twitter.com/oauth/authorize';
    $auth->accessTokenUrl   = 'https://api.twitter.com/oauth/access_token';

    return $auth;
  }
}