<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/inventario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Inventario extends InventarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $cantidad = null;
    protected $precio = null;
    protected $fecha = null;
    protected $id_usuario = null;
    protected $id_producto = null;

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFecha($value)
    {
        if (Validator::validateDate($value, 1, 50)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_usuario = $value;
            return true;
        } else {
            return false;
        }
    }
    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_producto = $value;
            return true;
        } else {
            return false;
        }
    }
    /*
    *   Métodos para obtener valores de los atributos.
    */
    public function getId()
    {
        return $this->id;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }
    public function getPrecio()
    {
        return $this->precio;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    public function getUsuario()
    {
        return $this->id_usuario;
    }

    public function getProducto()
    {
        return $this->id_producto;
    }

   }