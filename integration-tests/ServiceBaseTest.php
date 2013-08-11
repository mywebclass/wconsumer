<?php
namespace Drupal\wconsumer\IntegrationTests;

use Drupal\wconsumer\Rest\Authentication\Credentials;
use Drupal\wconsumer\IntegrationTests\TestService;


class ServiceBaseTest extends DrupalTestBase {

  public function testCredentialsGettingSetting() {
    $service = new TestService();

    // Initial state
    $this->assertNull($service->getCredentials());

    // Insert new credentials
    $credentials = new Credentials('123', 'abc');
    $service->setCredentials($credentials);
    $this->assertEquals($credentials, $service->getCredentials());

    // Update existing credentials
    $credentials = new Credentials('321', 'abc');
    $service->setCredentials($credentials);
    $this->assertEquals($credentials, $service->getCredentials());

    // Remove credentials
    $service->setCredentials(null);
    $this->assertNull($service->getCredentials());
  }

  public function testGetCredentialsDoesntFailIfServiceCredentialsAreNotSet() {
    $service = new TestService();

    $exception = null;
    try {
      $service->getCredentials();
    }
    catch (\Exception $e) {
      $exception = $e;
    }

    $this->assertNull($exception);
  }

  public function testServiceCredentialsGettingSetting() {
    $service = new TestService();

    // Initial state
    $this->assertNull($service->getServiceCredentials());

    // Insert new credentials
    $credentials = new Credentials('123', 'abc');
    $service->setServiceCredentials($credentials);
    $this->assertEquals($credentials, $service->getServiceCredentials());

    // Update existing credentials
    $credentials = new Credentials('321', 'abc');
    $service->setServiceCredentials($credentials);
    $this->assertEquals($credentials, $service->getServiceCredentials());

    // Remove credentials
    $service->setServiceCredentials(null);
    $this->assertNull($service->getServiceCredentials());
  }

  /**
   * @dataProvider isInitializedDataProvider
   */
  public function testCheckAuthentication($serviceCredentials, $userCredentials, $domain, $expectedResult) {
    $service = new TestService();

    $service->setServiceCredentials($serviceCredentials);
    $service->setCredentials($userCredentials);

    $this->assertSame($expectedResult, $service->checkAuthentication($domain));
  }

  public function testCheckAuthenticationForSpecifiedUser() {
    $credentials = new Credentials('usernmae', 'password');

    $service = new TestService();
    $this->assertFalse($service->checkAuthentication('user'));
    $this->assertFalse($service->checkAuthentication('user', 77));

    $service->setCredentials($credentials);
    $this->assertTrue($service->checkAuthentication('user'));
    $this->assertFalse($service->checkAuthentication('user', 77));

    $service->setCredentials($credentials, 77);
    $this->assertTrue($service->checkAuthentication('user'));
    $this->assertTrue($service->checkAuthentication('user', 77));

    $service->setCredentials(null);
    $this->assertFalse($service->checkAuthentication('user'));
    $this->assertTrue($service->checkAuthentication('user', 77));

    $service->setCredentials(null, 77);
    $this->assertFalse($service->checkAuthentication('user'));
    $this->assertFalse($service->checkAuthentication('user', 77));
  }

  public static function isInitializedDataProvider() {
    $credentials = new Credentials('123', 'abc');

    return array(
      array(NULL, NULL, 'user', FALSE),
      array(NULL, NULL, 'system', FALSE),
      array(NULL, NULL, 'unknown', FALSE),
      array($credentials, NULL, 'user', FALSE),
      array($credentials, NULL, 'system', TRUE),
      array($credentials, NULL, 'unknown', FALSE),
      array(NULL, $credentials, 'user', TRUE),
      array(NULL, $credentials, 'system', FALSE),
      array(NULL, $credentials, 'unknown', FALSE),
      array($credentials, $credentials, 'user', TRUE),
      array($credentials, $credentials, 'system', TRUE),
      array($credentials, $credentials, 'unknown', FALSE),
    );
  }

}