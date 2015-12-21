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
     * @param $name
     * @param $identifier
     * @return string
     */
    public function getUrl($name, $identifier)
    {
        $dao = $this->getRouteDao();
        $route = $dao->findByNameAndIdentifier((string) $name, (string) $identifier);

        if ($route) {
            return $route->url;
        }

        return '';
    }

    /**
     * @param string $name
     * @param string $identifier
     * @param string $url
     */
    public function update($name, $identifier, $url)
    {
        $dao = $this->getRouteDao();

        if (empty($url)) return false;

        if ($url[0] !== '/') {
            $url = '/' . $url; // Prefix urls with /
        }

        $routeModel = $dao->findByNameAndIdentifier((string) $name, (string) $identifier);

        if ( ! $routeModel) {
            // Create new route because it doesn't exist yet
            $routeModel = new Route();
        }

        $routeModel->name = $name;
        $routeModel->identifier = (string) $identifier;
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