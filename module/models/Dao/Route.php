<?php
namespace DatabaseRouter\Models\Dao;

use Vegas\Db\Dao\DefaultDao;
use DatabaseRouter\Models\Route as RouteModel;

class Route extends DefaultDao
{
    /**
     * @param string $url
     * @return RouteModel
     */
    public static function findByUrl($url)
    {
        return RouteModel::findFirst([
            'conditions' => [
                'url' => $url
            ]
        ]);
    }

    /**
     * @param string $route
     * @param string $ownerId
     * @return RouteModel
     */
    public static function findByRoute($route, $ownerId)
    {
        return RouteModel::findFirst([
            'conditions' => [
                'route' => $route,
                'owner_id' => $ownerId
            ]
        ]);
    }
}