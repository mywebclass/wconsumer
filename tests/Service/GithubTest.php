<?php
namespace Drupal\wconsumer\Tests\Service;

use Drupal\wconsumer\Rest\Authentication\Oauth2\Oauth2;
use Drupal\wconsumer\Service\Github;



class GithubTest extends \PHPUnit_Framework_TestCase {
  public function testConstruction() {
    $github = new Github();
    $this->assertInstanceOf(Oauth2::getClass(), $github->authentication);
  }

  public function testName() {
    $github = new Github();
    $this->assertSame('github', $github->getName());
  }
}