<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/productos_queries.php');

class Producto extends ProductoQueries
{
    protected $id = null;
    protected $idvalo = null;
    protected $nombrep = null;
    protected $imgp = null;
    protected $descripp = null;
    protected $modelo = null;
    protected $estadop = null;
    const CONDICION = array(
        array('Nuevo', 'Nuevo'),
        array('Usado','Usado'),
        array('Reacondicionado','Reacondicionado')
    );
    protected $usuario = null;
    protected $existencia_producto = null;
    protected $precio_producto = null;
    protected $ruta = '../../../images/productos/';

    //Metodo para validar id
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar valor del id
    public function setIdValo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->idvalo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNombre($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->nombrep = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar imagen
    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 500, 500)) {
            $this->imgp = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar descripcion
    public function setDescripcion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->descripp = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar estado de productos
    public function setEstadoProductos($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estadop = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar modelo
    public function setModelo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar condicion
    public function setCondicion($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->condicion = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar usuario
    public function setUsuario($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar existencias
    public function setExistencia($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->existencia_producto = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar precio
    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio_producto = $value;
            return true;
        } else {
            return false;
        }
    }



    public function getId()
    {
        return $this->id;
    }

    public function getIdValo()
    {
        return $this->idvalo;
    }

    public function getExistencia()
    {
        return $this->existencia_producto;
    }

    public function getPrecio()
    {
        return $this->precio_producto;
    }

    public function getNombre()
    {
        return $this->nombrep;
    }

    public function getImagen()
    {
        return $this->imgp;
    }


    public function getDescripcion()
    {
        return $this->descripp;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getEstado()
    {
        return $this->estadop;
    }

    public function getCondicion()
    {
        return $this->condicion;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getRuta()
    {
        return $this->ruta;
    }
}
