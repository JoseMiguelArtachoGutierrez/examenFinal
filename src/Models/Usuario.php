<?php

namespace Models;

use PDO;
use PDOException;
use Lib\BaseDatos;

class Usuario{
    private string|null $id;
    private string $nombreUsuario;
    private string $password;
    private string $email;
    private string $rol;

    private BaseDatos $db;

    /*
    public function __construct(string|null $id,string $nombre,string $apellidos,string $email,string $password,string $rol){
        $this->db=new BaseDatos();
        $this->id=$id;
        $this->nombre=$nombre;
        $this->apellidos=$apellidos;
        $this->email=$email;
        $this->password=$password;
        $this->rol=$rol;
    }
*/
    /**
     * @param string|null $id
     * @param string $nombreUsuario
     * @param string $password
     * @param mixed $DNI
     * @param string $nombreCompleto
     * @param string $apellidoUNO
     * @param string $apellidoDos
     * @param string $email
     * @param bool $habilitado
     * @param string $rol
     */
    public function __construct(?string $id, string $nombreUsuario, string $password, string $email, string $rol){
        $this->db=new BaseDatos();
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
        $this->email = $email;
        $this->rol = $rol;
    }



    public static function fromArray(array $data): Usuario {
        return new Usuario(
            $data['id']?? null,
            $data['nombreUsuario']?? '',
            $data['password']?? '',
            $data['email']?? '',
            $data['rol']?? 'user',
        );
    }

    public function desconecta(){
        $this->db->cierraConexion();
    }
    public function create(){
        
        $id=null;
        $nombreUsuario=$this->getNombreUsuario();
        $password=$this->getPassword();
        $email=$this->getEmail();
        $rol=$this->getRol();
        
        try {
            $stm=$this->db->preparada("insert into usuarios (id,nombreUsuario,password,email,rol)values(:id,:nombreUsuario,:password,:email,:rol)");
            $stm->bindValue(":id",$id);
            $stm->bindValue(":nombreUsuario",$nombreUsuario);
            $stm->bindValue(":password",$password);
            $stm->bindValue(":email",$email);
            $stm->bindValue(":rol",$rol);

            $stm->execute();
            $resultado=true;
            
            
        }catch (\PDOException $e){
            $resultado=false;

        }

 
        return $resultado;
    }
    public function update(){
        $id=$this->getId();
        $nombreUsuario=$this->getNombreUsuario();
        $password=$this->getPassword();
        $email=$this->getEmail();
        $rol='profesor';

        try {
            $stm=$this->db->preparada("update usuarios set nombreUsuario=':nombreUsuario',
                    nombreCompleto=':nombreCompleto',dni=':dni',password=':password',apellidoUNO=':apellidoUNO',
                    apellidoDOS=':apellidoDOS',email':email',habilitado=':habilitado',rol=':rol' where id=':id'  ");
            $stm->bindValue(":id",$id);
            $stm->bindValue(":nombreUsuario",$nombreUsuario);
            $stm->bindValue(":password",$password);
            $stm->bindValue(":email",$email);
            $stm->bindValue(":rol",$rol);
            $stm->execute();
            $resultado=true;
        }catch (\PDOException $e){
            $resultado=false;
        }
        return $resultado;
    }
    public function login(){
        $nombreUsuario = $this->getNombreUsuario();
        $password=$this->getPassword();
        $usuario=$this->buscaUsuario($nombreUsuario);
        print_r($usuario);
        if ($usuario !==false){
            $verify=password_verify($password,$usuario->password);
            if ($verify){
                return $usuario;
            }
        }else{
            return false;
        }
    }
    public function desabilitado(){
        $nombreUsuario=$this->getNombreUsuario();
        $usuario=$this->buscaUsuario($nombreUsuario);
        $id=$usuario->id;
        try {
            $stm=$this->db->preparada("update usuarios set habilitado='false' where id=':id' ");
            $stm->bindValue(":id",$id);
            $stm->execute();
            $resultado=true;
        }catch (\PDOException $e){
            $resultado=false;
        }
        return $resultado;
    }
    /*
    public function buscaDNI(){
        $dni=$this->getDNI();
        $cons=$this->db->preparada("SELECT * FROM usuarios WHERE dni=:dni");
        $cons->bindValue(':dni',$dni,PDO::PARAM_STR);
        try{
            $cons->execute();
            if ($cons && $cons->rowCount()==1){
                $result=true;
            }
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }*/
    public function buscaID(){
        $id=$this->getId();
        $cons=$this->db->preparada("SELECT * FROM usuarios WHERE id=:id");
        $cons->bindValue(':id',$id,PDO::PARAM_STR);
        try{
            $cons->execute();
            if ($cons && $cons->rowCount()==1){
                $result=$cons->fetch(PDO::FETCH_OBJ);
            }else{
                $result=false;
            }
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function buscaUsuario($nombreUsuario){
        
        $cons=$this->db->preparada("SELECT * FROM usuarios WHERE nombreUsuario=:nombreUsuario");
        $cons->bindValue(':nombreUsuario',$nombreUsuario,PDO::PARAM_STR);
        try{
            $cons->execute();
            if ($cons && $cons->rowCount()==1){
                $result=$cons->fetch(PDO::FETCH_OBJ);
            }
        }catch (PDOException $err){
            $result=false;
        }
        return $result;
    }
    public function getAll(){
        $this->db->consulta("select * from usuarios order by id desc ;");
        $categorias=$this->db->extraer_todos();
        $this->db->cierraConexion();
        return $categorias;
    }

    /* GETTERS Y SETTERS */

    public function getId(): ?string{
        return $this->id;
    }
    public function setId(?string $id): void{
        $this->id = $id;
    }
    public function getNombreUsuario(): string{
        return $this->nombreUsuario;
    }
    public function setNombreUsuario(string $nombreUsuario): void{
        $this->nombreUsuario = $nombreUsuario;
    }
    public function getPassword(): string{
        return $this->password;
    }
    public function setPassword(string $password): void{
        $this->password = $password;
    }
    public function getEmail(): string{
        return $this->email;
    }
    public function setEmail(string $email): void{
        $this->email = $email;
    }
    public function getRol(): string{
        return $this->rol;
    }
    public function setRol(string $rol): void{
        $this->rol = $rol;
    }

}