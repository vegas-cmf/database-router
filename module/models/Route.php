<?php
namespace DatabaseRouter\Models;

use Vegas\MultiSite\CollectionAbstract;

class Route extends CollectionAbstract
{
    public $name;
    public $identifier; // identifier + route name = unique key
    public $priority;
    public $url;

    public function _getSource()
    {
        return 'vegas_routes';
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getPriority()
    {
        return $this->priority;
    }
}
