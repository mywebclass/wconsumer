<?php
namespace Drupal\wconsumer\Service;

use Drupal\wconsumer\Authentication\Oauth\Oauth;



class Linkedin extends Base {
  protected $name = 'linkedin';
  protected $apiUrl = 'http://api.linkedin.com/v1/';



  public function getMeta() {
    $meta = parent::getMeta();

    $meta->niceName            = 'LinkedIn';
    $meta->consumerKeyLabel    = 'API Key';
    $meta->consumerSecretLabel = 'Secret Key';
    $meta->registerAppUrl      = 'https://www.linkedin.com/secure/developer?newapp';

    return $meta;
  }

  protected function initAuthentication() {
    $auth = new Oauth($this);

    $auth->requestTokenUrl = 'https://api.linkedin.com/uas/oauth/requestToken';
    $auth->authorizeUrl    = 'https://www.linkedin.com/uas/oauth/authenticate';
    $auth->accessTokenUrl  = 'https://api.linkedin.com/uas/oauth/accessToken';

    return $auth;
  }
}