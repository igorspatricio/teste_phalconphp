<?php



use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as Paginator;

class Relacaotagnoticia extends Model
{
    public function initialize()
    {
        $this->setSource("relacaotagnoticia");
    }

}