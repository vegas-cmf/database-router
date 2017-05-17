Vegas CMF Database router
======================

INSTALL AT A NEW PROJECT
--
* use `Vegas\Mvc\Router\Adapter\Mongo` adapter in `Bootstrap::initRoutes`
* register `databaseRouteManager` service
* add `route` config in Module
```
return [
    'routes' => [
        'route_name' => [
            'module'     => 'ModuleName',
            'controller' => 'Frontend\ControllerName',
            'action'     => 'index',
        ],
    ]
];
```
* create new route
```
$routeManager = $this->getDI()->get('databaseRouteManager');
$routeManager->update('route_name', PAGE_OBJECT_ID, /URL);
```

TEST OLD-SCHOOL
--
```
cp ./tests/config.php.sample ./tests/config.php
composer install
php ./vendor/bin/phpunit -c tests/phpunit.xml
```

TEST DOCKER
--
```
cp ./tests/config.php.sample ./tests/config.php
yake composer install
yake up
yake phpunit -c tests/phpunit.xml
```