<?php

use Phalcon\Http\Request;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;


class NoticiaController extends ControllerBase
{
    private $mensagemDeErro = '';


    public function listaAction()
    {
        
        $this->view->pick("noticia/listar");
        $this->view->noticias = Noticia::find();
        
    }

    public function listaTagAction($tag)
    {
        
        $this->view->pick("noticia/listar");
        $this->view->noticias = Noticia::find();
        
    }


    public function cadastrarAction()
    {

        $this->view->pick("noticia/cadastrar");
        $this->view->form = $form;


    }

    public function editarAction($id)
    {
        
        $this->view->pick("noticia/editar");
        $this->view->form = $form;
        $this->view->noticia = Noticia::findFirst($id);
    }

    public function salvarAction()
    {
        // return $this->response->redirect(array('for' => 'noticia.lista'));


        $form = $this->startForm();

        $noticia = new Noticia();
        $form->bind($_POST, $noticia);
        

        $id = explode("/", $this->request->getHTTPReferer());
        $id = $id[ count($id) - 1 ];
        
        if(is_numeric($id)){// não consegui achar o jeito certo de fazer essa validação então improvisei --mudar se der tempo 
            $id = intval($id);
            if (!$form->isValid($_POST)) {
                foreach ($form->getMessages() as $message) {                    
                    $this->flashSession->error($message);
                    $this->dispatcher->forward([
                        'controller' => $this->router->getControllerName(),
                        'action'     => 'editar',
                        'params'     => [$id],
                    ]);                
                }
                return;
            }
            $noticia->setId($id);
            $noticia->setData_cadastro(Noticia::findFirst($id)->getData_cadastro());
            
            $noticia->setDateTimeAttNow();
            $noticia->save();
            $this->flashSession->success("Noticia alterada com sucesso!");
            return $this->response->redirect('/noticias');
    
        }

        if (!$form->isValid($_POST)) {
            foreach ($form->getMessages() as $message) {
                
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'cadastrar',
                ]);                
            }
            return;
        }

        
        $noticia->setDateTimeAttNow();
        $noticia->setDateTimeCreationNow();
        $noticia->save();

        $this->flashSession->success("Noticia cadastrada com sucesso!");
        return $this->response->redirect('/noticias');
    
        

    }

    public function excluirAction($id)
    {
        $noticia = Noticia::findFirst($id);
        

        if($noticia->delete())
            $this->flashSession->success("Noticia deletada com sucesso!");
        else
            $this->flashSession->error("Desculpe mas não foi possivel deletar o robo.");

        return $this->response->redirect('/noticias');
        //return $this->response->redirect(array('for' => 'noticia.lista'));
    }


    public function startForm(){
    $form = new Form();

    $titulo = new Text(
        'titulo'
    );
    $titulo->addValidator(
        new PresenceOf(
            [
                'message' => 'Titulo é requirido!',
            ]
        )
    );

    $texto = new Text(
        'texto'
    );

    $texto->addValidator(
        new StringLength(
            [
                "max"            => 255,
                "messageMaximum" => "Quantidade máxima de caracteres excedida. Máximo de 255!",
            ]
        )
    );

    $form->add($titulo);
    $form->add($texto);

    return $form;
    }
}