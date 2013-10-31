<?php
namespace Drupal\wconsumer\IntegrationTests\Service;



class FacebookTest extends AbstractServiceTest {

  public function testValidateServiceCredentials() {
    $this->markTestSkipped('Service credentials validation is not implemented for Facebook service');
  }

  protected function currentUserInfoApiEndpoint() {
    return 'me';
  }
}