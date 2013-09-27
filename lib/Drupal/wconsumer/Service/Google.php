<?php
namespace Drupal\wconsumer\Service;

use Drupal\wconsumer\Authentication\Credentials;
use Drupal\wconsumer\Authentication\Oauth2\Oauth2;



class Google extends Base {
  protected $name = 'google';
  protected $apiUrl = 'https://www.googleapis.com/';



  public function getMeta() {
    $meta = parent::getMeta();

    $meta->niceName             = 'Google';
    $meta->consumerKeyLabel     = 'Client ID';
    $meta->consumerSecretLabel  = 'Client Secret';
    $meta->registerAppUrl       = 'https://cloud.google.com/console';

    return $meta;
  }

  public function validateServiceCredentials(Credentials $credentials) {
    // Disable service credentials validation since Google always returns 400 Bad Request error
    // and it's not possible to detect if that's due to invalid credentials, invalid code or malformed request.
    return TRUE;
  }

  protected function initAuthentication() {
    $auth = new Oauth2($this);

    $auth->authorizeURL   = 'https://accounts.google.com/o/oauth2/auth';
    $auth->accessTokenURL = 'https://accounts.google.com/o/oauth2/token';

    return $auth;
  }
}
