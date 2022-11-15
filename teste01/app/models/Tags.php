<?php



use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as Paginator;

class Tags extends Model
{
    public function initialize()
    {
        $this->setSource("tags");
    }

}