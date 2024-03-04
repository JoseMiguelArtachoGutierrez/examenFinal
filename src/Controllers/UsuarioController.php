<?php

namespace Controllers;

use Lib\Pages;
use Models\Usuario;
use utils\utils;

class UsuarioController{
    private Pages $pages;
    public function __construct(){
        $this->pages=new Pages();
    }

    public function indetifica(){
        $this->pages->render("usuario/login");
    }
    public static function todos(){
        $usuario=Usuario::fromArray([]);
        return $usuario->getAll();
    }
    public function login(){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            if ($_POST['data']){
                $login=$_POST['data'];
                $usuario= Usuario::fromArray($login);
                $identity=$usuario->login();

                if($identity!=false && is_object($identity)){
                    $_SESSION['identity']=$identity;
                    if ($identity->rol == 'direccion'){
                        $_SESSION['direccion']=true;
                    }
                }
                
            }
        }else{
            $_SESSION['error_login']='identificacion fallida';
        }
        

        header("Location: " . BASE_URL);
    }
    public function registro(){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if ($_POST['data']){
                $registro=$_POST['data'];
                
                $registro['password']=password_hash($registro['password'],PASSWORD_BCRYPT);
                $usuario=Usuario::fromArray($registro);
                
                $resultado=$usuario->create();
                if ($resultado){
                    $_SESSION["register"]="complete";
                }else{
                    $_SESSION["register"]="failed1";
                }
            }else{
                $_SESSION["register"]="failed2";
            }

            header("Location:".BASE_URL."Usuario/indetifica");
        }
        $this->pages->render("usuario/registro");
    }
    public function update($id=null){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if ($_POST['data']){
                $registro=$_POST['data'];
                $registro['password']=password_hash($registro['password'],PASSWORD_BCRYPT);
                $usuario=Usuario::fromArray($registro);
                $existeDNI=$usuario->buscaID();
                if (!$existeDNI && is_object($existeDNI)){
                    foreach ($usuario as $variable){
                        print_r($variable);
                    }
                    die();
                    $resultado=$usuario->update();
                    if ($resultado){
                        $_SESSION["update"]="complete";
                    }else{
                        $_SESSION["update"]="failed";
                    }
                }else{
                    $_SESSION["update"]="failed";
                }

            }else{
                $_SESSION["update"]="failed";
            }
        }
        $this->pages->render("usuario/update",["id"=>$id]);
    }

    public function logout(){
        utils::deleteSession('identity');
        header("Location: " . BASE_URL);
    }


}