<?php



use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as Paginator;

class Noticia extends Model
{



    public function initialize()
    {
        $this->setSource("noticia");
    }

    public function setDateTimeCreationNow(){
        
        $this->data_cadastro = $this->generateDate();
    }

    public function getData_cadastro(){
        return $this->data_cadastro;
    }
    public function setData_cadastro($data){
        $this->data_cadastro = $data;
    }

    public function setDateTimeAttNow(){
        $this->data_ultima_atualizacao = $this->generateDate();
    }

    public function setId($id){
        $this->id = $id;
    }


    public function generateDate(){
        $date = new DateTime();
        return $date->format('Y-m-d H:i:s');
    }


}