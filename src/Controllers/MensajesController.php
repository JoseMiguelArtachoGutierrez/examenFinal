<?php

namespace Controllers;

use Lib\Pages;
use Models\Mensaje;
use Controllers\EmailController;
use Controllers\UsuarioController;

class MensajesController
{
    private Pages $pages;
    function __construct(){
        $this->pages= new Pages();
    }
    public function indetifica(){
        $usuarios=UsuarioController::todos();
        $this->pages->render("mensaje/mandarMensaje",["usuarios"=>$usuarios]);
    }
    public function mostrarTodos(){
        $mensaje=Mensaje::fromArray([]);
        $mensajes=$mensaje->getAll();
        $this->pages->render("mensaje/verTusMensajes",['mensajes'=>$mensajes]);
    }
    public function registro(){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if ($_POST['data']){
                $registro=$_POST['data'];
                $mensaje=Mensaje::fromArray($registro);
                var_dump($mensaje);
                
                EmailController::enviarCorreo($mensaje->getPara(),$mensaje->getAsunto(),$mensaje->getCuerpo());
                
                $resultado=$mensaje->create();
                if ($resultado){
                    $_SESSION["registerMensaje"]="complete";
                }else{
                    $_SESSION["registerMensaje"]="failed";
                }
            }else{
                $_SESSION["registerMensaje"]="failed";
            }
            header("Location:".BASE_URL."Mensaje/indetifica");
        }
        $this->pages->render("mensaje/mandarMensaje");
    }
    public function eliminar($id){
        $mensaje= Mensaje::fromArray(["id"=>$id]);
        $mensaje->delete();
        header("Location:".BASE_URL."Mensaje/mostrarTodos");
    }
}