<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/genero_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Genero extends GeneroQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $genero = null;
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

    public function setGenero($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->genero = $value;
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

    public function getGenero()
    {
        return $this->genero;
    }
   }
