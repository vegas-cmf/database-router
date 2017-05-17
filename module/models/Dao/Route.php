<?php
namespace DatabaseRouter\Models\Dao;

use DatabaseRouter\Models\Route as RouteModel;
use Vegas\Db\Dao\DefaultDao;

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
            ],
            'sort' => [
                'priority' => -1,
                'created_at' => -1
            ]
        ]);
    }

    /**
     * @param string $name
     * @param string $identifier
     * @return RouteModel
     */
    public static function findByNameAndIdentifier($name, $identifier)
    {
        return RouteModel::findFirst([
            'conditions' => [
                'name' => $name,
                'identifier' => $identifier
            ],
            'sort' => [
                'priority' => -1,
                'created_at' => -1
            ]
        ]);
    }
}