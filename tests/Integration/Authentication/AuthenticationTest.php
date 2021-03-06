<?php
namespace Drupal\wconsumer\Tests\Integration\Authentication;

use Drupal\wconsumer\Tests\Integration\DrupalTestBase;
use Drupal\wconsumer\Tests\Integration\TestService;
use Drupal\wconsumer\Authentication\AuthInterface;
use Drupal\wconsumer\Authentication\Authentication;
use Drupal\wconsumer\Service\Service;




abstract class AuthenticationTest extends DrupalTestBase {

  /**
   * @var \PHPUnit_Framework_MockObject_MockObject
   */
  protected $php;



  public function setUp() {
    parent::setUp();

    // There are two reasons to disable drupal_goto() by default:
    //  1. It just terminates current process with an empty phpunit output.
    //  2. By default we don't expected redirects, b/c it's a control flow violation.
    $this->setupDrupalGotoMock();
  }

  /**
   * @param Service $service
   * @return Authentication|AuthInterface
   */
  protected function auth(Service $service = null) {
    if (!isset($service)) {
      $service = $this->service();
    }

    $authClass = $this->authClass();
    $auth = new $authClass($service);
    return $auth;
  }

  protected function authClass() {
    return str_replace('\\Tests\Integration\\', '\\', preg_replace('/Test$/', '', get_class($this)));
  }

  protected function service() {
    return new TestService();
  }

  private function setupDrupalGotoMock() {
    $this->php =
      \PHPUnit_Extension_FunctionMocker::start($this, $this->getNamespace($this->authClass()))
        ->mockFunction('drupal_goto')
      ->getMock();

    $annotations = $this->getAnnotations();
    $neverOrAny = !isset($annotations['method']['bypassDrupalGoto']) ? $this->never() : $this->any();
    $this->php
      ->expects($neverOrAny)
      ->method('drupal_goto');
  }

  private function getNamespace($objectOrClass) {
    $class = new \ReflectionClass($objectOrClass);
    return $class->getNamespaceName();
  }
}