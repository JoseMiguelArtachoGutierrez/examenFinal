<?php

namespace Routes;

use Controllers\UsuarioController;
use Controllers\DashBoardController;
use Controllers\ErrorController;
use Controllers\MensajesController;
use Lib\Router;

class Routes
{
    public static function index(){
        // INICIO
        Router::add('GET','/',function (){
            return (new DashBoardController())->index();
        });
        // USUARIOS
        Router::add('GET','/Usuario/indetifica',function (){
            return (new UsuarioController())->indetifica();
        });
        Router::add('POST','/Usuario/login',function (){
            return (new UsuarioController())->login();
        });
        Router::add('GET','/Usuario/logout',function (){
            return (new UsuarioController())->logout();
        });
        Router::add('GET','/Usuario/registro',function (){
            return (new UsuarioController())->registro();
        });
        Router::add('POST','/Usuario/registro',function (){
            return (new UsuarioController())->registro();
        });

        /* MENSAJES */
        Router::add('GET','/Mensaje/indetifica',function (){
            return (new MensajesController())->indetifica();
        });
        Router::add('GET','/Mensaje/registro',function (){
            return (new MensajesController())->registro();
        });
        Router::add('POST','/Mensaje/registro',function (){
            return (new MensajesController())->registro();
        });
        Router::add('GET','/Mensaje/mostrarTodos',function (){
            return (new MensajesController())->mostrarTodos();
        });
        Router::add('GET','/Mensaje/eliminar/:id',function ($id){
            return (new MensajesController())->eliminar($id);
        });
        // ERROR
        Router::add('GET','/Error/error/', function (){
            return (new ErrorController())->error404();
        });
        Router::dispatch();
    }
}