<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dashboard/dao/marca_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Marca extends MarcaQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $marca = null;
    protected $imagen_marca = null;
    protected $ruta_imagen = '../../images/marcas/';
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

    public function setMarca($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->marca = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($value)
    {
        if (Validator::validateImageFile($value, 1000, 1000)) {
            $this->imagen_marca = Validator::getFileName();
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

    public function getMarcas()
    {
        return $this->marca;
    }
    public function getImagen()
    {
        return $this->imagen_marca;
    }

    public function getRutaImagen()
    {
        return $this->ruta_imagen;
    }
   }