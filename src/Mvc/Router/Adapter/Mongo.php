<?php
namespace Vegas\Mvc\Router\Adapter;

use Phalcon\DI;
use Phalcon\DiInterface;
use Phalcon\Mvc\Router;

/**
 * Class Mongo
 * Default router using standard Phalcon router.
 *
 * @package Vegas\Mvc\Router\Adapter
 */
class Mongo extends Router implements DI\InjectionAwareInterface
{

    /**
     * Standard router constructor
     *
     * @param DiInterface $dependencyInjector
     * @param bool $keepDefaultRoutes
     */
    public function __construct(DiInterface $dependencyInjector, $keepDefaultRoutes = false)
    {
        parent::__construct($keepDefaultRoutes);
        $this->removeExtraSlashes(true);
        $this->setDI($dependencyInjector);
    }

    public function handle($uri = null)
    {
        var_dump($uri); exit;

        parent::handle($uri);
    }
}
