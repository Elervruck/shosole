<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/cargo_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Cargo extends CargoQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $cargo = null;
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

    public function setCargo($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->cargo = $value;
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

    public function getCargo()
    {
        return $this->cargo;
    }

   }
