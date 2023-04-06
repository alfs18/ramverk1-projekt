<?php

namespace Alfs18\User;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the UserController.
 */
class UserControllerTest extends TestCase
{
    /**
     * Test the route "login".
     */
     public function testLoginAction()
     {
         $this->di = new DIFactoryConfig();
         $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

         $controller = new UserController();
         $controller->setDI($this->di);
         $controller->initialize();
         $res = $controller->loginAction();

         $this->assertIsObject($res);
     }
}
