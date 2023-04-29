<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/modelo_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Cargo extends ModeloQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $modelo = null;
    protected $id_marca = null;

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

    public function setModelo($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->modelo = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setMarca($value)
    {
        if (Validator::validateAlvalidateNaturalNumberhabetic($value)) {
            $this->id_marca = $value;
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

    public function getModelo()
    {
        return $this->modelo;
    }

    public function getMarca()
    {
        return $this->id_marca;
    }

   }
