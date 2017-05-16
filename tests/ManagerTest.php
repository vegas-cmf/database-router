<?php

namespace Vegas\Tests;

use DatabaseRouter\Models\Route;
use DatabaseRouter\Services\Manager;
use Phalcon\DI;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Manager
     */
    protected function getRouteManager()
    {
        $dao = new Manager();
        $dao->setDI(DI::getDefault());

        return $dao;
    }

    public function testInsert()
    {
        $routeManager = $this->getRouteManager();

        $testRoute = $routeManager->update('test', 1, '/test', 100);
        $testRoute2 = $routeManager->update('test', 2, '/test', 50);

        $this->assertInstanceOf(Route::class, $testRoute);
        $this->equalTo($testRoute->getIdentifier(), 1);
        $this->assertEquals($testRoute->getName(), 'test');

        $this->assertInstanceOf(Route::class, $testRoute2);
        $this->equalTo($testRoute2->getIdentifier(), 2);
        $this->assertEquals($testRoute2->getName(), 'test');
    }

    public function testSelect()
    {
        $routeManager = $this->getRouteManager();

        $testRoute = $routeManager->findByUrl('/test');
        $this->assertEquals($testRoute->getIdentifier(), 1);

        $testRoute2url = $routeManager->getUrl('test', 2);
        $this->assertEquals($testRoute2url, '/test');
    }

    public function testUpdate()
    {
        $routeManager = $this->getRouteManager();

        $routeManager->update('test', 1, '/test', 10);

        $testRoute = $routeManager->findByUrl('/test');
        $this->assertEquals($testRoute->getIdentifier(), 2);
    }

    public function testDeleteByName()
    {
        $routeManager = $this->getRouteManager();

        $testRoute = $routeManager->findByUrl('/test');
        $this->assertEquals($testRoute->getIdentifier(), 2);

        $routeManager->deleteByName('test');

        $testRoute = $routeManager->findByUrl('/test');
        $this->assertEquals($testRoute, null);
    }

    public function testPrioritySort()
    {
        $routeManager = $this->getRouteManager();
        $routeManager->deleteByName('prio');

        $routeManager->update('prio', 1, '/prio', 10);
        sleep(1);
        $routeManager->update('prio', 2, '/prio', 10);

        $testRoute = $routeManager->findByUrl('/prio');
        $this->assertEquals($testRoute->getIdentifier(), 2);
    }
}