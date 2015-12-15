<?php
namespace DatabaseRouter\Services;

use DatabaseRouter\Models\Route;
use Phalcon\DI\InjectionAwareInterface;
use Vegas\DI\InjectionAwareTrait;

class Manager implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * @param string $url
     * @return Route
     */
    public function findByUrl($url)
    {
        $dao = $this->getRouteDao();

        return $dao->findByUrl($url);
    }

    /**
     * @param string $route
     * @param string $ownerId
     * @param string $url
     */
    public function update($route, $ownerId, $url)
    {
        $dao = $this->getRouteDao();

        if (empty($url)) return false;

        if ($url[0] !== '/') {
            $url = '/' . $url; // Prefix urls with /
        }

        $routeModel = $dao->findByRoute((string) $route, (string) $ownerId);

        if ( ! $routeModel) {
            // Create new route because it doesn't exist yet
            $routeModel = new Route();
        }

        $routeModel->route = $route;
        $routeModel->owner_id = (string) $ownerId;
        $routeModel->url = $url;

        $routeModel->save();

        return $routeModel;
    }

    /**
     * @return \Vegas\Db\Dao\Manager
     */
    private function getDaoManager()
    {
        return $this->getDI()->get('dao');
    }

    /**
     * @return \DatabaseRouter\Models\Dao\Route
     */
    private function getRouteDao()
    {
        $dao = $this->getDaoManager();

        return $dao->get(Route::class);
    }
}