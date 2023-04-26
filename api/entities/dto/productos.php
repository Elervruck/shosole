<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/productos_queries.php');

class Productos extends ProductoQueries{

    protected $id = null;
    protected $nombre_Producto = null;
    protected $descripcion_producto = null;
    protected $imagen_producto = null;
    protected $estado_producto = null;
    protected $id_usuario = null;
    protected $id_modelo = null,
    protected $id_condicion_producto = null;
    protected $ruta_imagen = '../../images/usuario/';


    public function setId($value){
        if(Validator::validatorNaturalNumbber($value)){
            $this->id = $value;
            return true;
        }else{
            return false;
        }
    }

    
    public function setNombre($value){
        if(Validator::validateAlphabetic($value, 1, 50)){
            $this->nombre_Producto = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setDescripcion($value){
        if(Validator::validateAlphabetic($value, 1, 50)){
            $this->descripcion_producto = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setImagen($value){
        if(Validator::validateImageFile($value, 1000, 1000)){
            $this->imagen_producto = Validator::getFileName();
            return true;
        }else{
            return false;
        }
    }

    public function setEstado($value){
        if(Validator::validateAlphabetic($value, 1, 50)){
            $this->estado_producto = $value;
            return true;
        }else{
            return false;
        }
    }

    public function setUsuario($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        }else {
            return false;
        }
    }

    public function setModelo($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->id_modelo = $value;
            return true;
        }else {
            return false;
        }
    }

    public function setCondicion($value){
        if (Validator::validateNaturalNumber($value)) {
            $this->id_condicion_producto = $value;
            return true;
        }else {
            return false;
        }
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre_Producto;
    }

    public function getDescripcion(){
        return $this->descripcion_producto; 
    }

    public function getImagen(){
        return $this->imagen_producto;
    }

    public function getEstado(){
        return $this->estado_producto;
    }

    public function getUsuario(){
        return $this->id_usuario;
    }

    public function getModelo(){
        return $this->id_modelo;
    }

    public function getCondicion(){
        return $this->id_condicion_producto;
    }

}