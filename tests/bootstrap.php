<?php
date_default_timezone_set('UTC');

//Test Suite bootstrap
include __DIR__ . "/../vendor/autoload.php";

define('TESTS_ROOT_DIR', dirname(__FILE__));

$configArray = require_once dirname(__FILE__) . '/config.php';

$config = new \Phalcon\Config($configArray);

// \Phalcon\Mvc\Collection requires non-static binding of service providers.
class DiProvider
{
    public function resolve(\Phalcon\Config $config)
    {
        $di = new \Phalcon\DI\FactoryDefault();
        $di->set('config', $config, true);

        /**
         * Collection manager
         */
        $di->set('collectionManager', function () {
            return new \Phalcon\Mvc\Collection\Manager();
        }, true);

        /**
         * MongoDB connection
         */
        $di->set('mongo', function () use ($config) {
            $connectionString = "mongodb://{$config->mongo->host}:{$config->mongo->port}";
            $mongo = new \MongoClient($connectionString);
            return $mongo->selectDb($config->mongo->dbname);
        }, true);

        /**
         * DAO
         */
        $di->set('dao', function () use ($di) {
            $dao = new \Vegas\Db\Dao\Manager;
            return $dao->setDI($di);
        }, true);

        $di->set('site', function() use ($di) {
            return new \MultiSite\Models\Site();
        }, true);

        \Phalcon\DI::setDefault($di);
    }

    public function registerModule($moduleName, $modulePath)
    {
        $loader = new \Phalcon\Loader();

        $loader->registerNamespaces(
            [
                $moduleName . '\Services' => $modulePath . '/services/',
                $moduleName . '\Models' => $modulePath . '/models/',
            ], true
        );

        $loader->register();
    }
}

$diProvider = new DiProvider();
$diProvider->resolve($config);
$diProvider->registerModule('DatabaseRouter', dirname(__FILE__) . '/../module');