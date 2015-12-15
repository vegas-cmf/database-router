<?php
namespace DatabaseRouter\Models;

use Vegas\MultiSite\CollectionAbstract;

class Route extends CollectionAbstract
{
    public $route;
    public $owner_id; // owner_id + route = unique key

    public $url;

    public function _getSource()
    {
        return 'vegas_routes';
    }
}
