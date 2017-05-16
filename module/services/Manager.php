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
     * @param string $name defined in Module config rule
     * @param string $identifier object ID
     * @param string $url relative URL started with /
     * @param int $priority the lowest the more important
     * @return bool|Route
     */
    public function update($name, $identifier, $url, $priority=10)
    {
        /** @var \DatabaseRouter\Models\Dao\Route $dao */
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
        $routeModel->priority = $priority;

        $routeModel->save();

        return $routeModel;
    }

    public function deleteByName($name)
    {
        /** @var \DatabaseRouter\Models\Dao\Route $dao */
        $dao = $this->getRouteDao();

        /** @var Route[] $routes */
        $routes = $dao->find([
            [
                'name' => $name
            ]
        ]);

        foreach ($routes as $route) {
            $route->delete();
        }
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