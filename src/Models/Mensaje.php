<?php

namespace Models;

use PDO;
use PDOException;
use Lib\BaseDatos;

class Mensaje{
    private string|null $id;
    private string $de;
    private string $asunto;
    private string $cuerpo;
    private string $para;
    private string $fecha;

    private BaseDatos $db;


    public function __construct(?string $id, string $de, string $asunto, string $cuerpo, string $para, string $fecha){
        $this->db=new BaseDatos();
        $this->id = $id;
        $this->de = $de;
        $this->asunto = $asunto;
        $this->cuerpo = $cuerpo;
        $this->para=$para;
        $this->fecha = $fecha;
    }



    public static function fromArray(array $data): Mensaje {
        return new Mensaje(
            $data['id']?? null,
            $data['de']?? '',
            $data['asunto']?? '',
            $data['cuerpo']?? '',
            $data['para']?? '',
            $data['fecha']?? '',
        );
    }

    public function desconecta(){
        $this->db->cierraConexion();
    }
    public function create(){
        $id=null;
        $de=$this->getDe();
        $asunto=$this->getAsunto();
        $cuerpo=$this->getCuerpo();
        $para=$this->getPara();
        $fecha=$this->getFecha();

        try {
            $stm=$this->db->preparada("insert into mensajes (id,de,asunto,cuerpo,para,fecha)values(:id,:de,:asunto,:cuerpo,:para,:fecha) ");
            $stm->bindValue(":id",$id);
            $stm->bindValue(":de",$de);
            $stm->bindValue(":asunto",$asunto);
            $stm->bindValue(":cuerpo",$cuerpo);
            $stm->bindValue(":para",$para);
            $stm->bindValue(":fecha",$fecha);
            $stm->execute();
            $resultado=true;
        }catch (\PDOException $e){
            $resultado=false;
        }
        
        return $resultado;
    }
    public function delete(){
        $id=$this->getId();
        try {
            $stm=$this->db->preparada("delete from mensajes where id=:id ");
            $stm->bindValue(":id",$id);
            $stm->execute();
            $resultado=true;
        }catch (\PDOException $e){
            $resultado=false;
        }
        return $resultado;
    }
    public function buscaID(){
        $id=$this->getId();
        $cons=$this->db->preparada("SELECT * FROM mensajes WHERE id=:id");
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

    public function getAll(){
        $this->db->consulta("select * from mensajes order by id desc ;");
        $mensajes=$this->db->extraer_todos();
        $this->db->cierraConexion();
        return $mensajes;
    }

    /* GETTERS Y SETTERS */

    public function getId(): ?string{
        return $this->id;
    }
    public function setId(?string $id): void{
        $this->id = $id;
    }

    public function getDe(): string{
        return $this->de;
    }
    public function setDe(string $de): void{
        $this->de = $de;
    }
    public function getAsunto(): string{
        return $this->asunto;
    }
    public function setAsunto(string $asunto): void{
        $this->asunto = $asunto;
    }
    public function getCuerpo(): string{
        return $this->cuerpo;
    }
    public function setCuerpo(string $cuerpo): void{
        $this->cuerpo = $cuerpo;
    }
    public function getPara(): string{
        return $this->para;
    }
    public function setPara(string $para): void{
        $this->para = $para;
    }
    public function getFecha(): string{
        return $this->fecha;
    }
    public function setFecha(string $fecha): void{
        $this->fecha = $fecha;
    }

}