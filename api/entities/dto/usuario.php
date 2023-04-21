<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/usuario_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Usuario extends UsuarioQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombres_usuario = null;
    protected $correo_usuario = null;
    protected $apellidos_usuario = null;
    protected $alias_usuario = null;
    protected $clave_usuario = null;
    protected $foto_usuario = null;
    protected $id_genero = null;
    protected $id_estado = null;
    protected $id_cargo = null;
    protected $ruta_imagen = '../../images/usuario/';

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

    public function setNombres($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombres_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellidos($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellidos_usuario = $value;
            return true;
        } else {
            return false;
        }
    }



    public function setAlias($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->alias_usuario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave_usuario = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_usuario = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setImagen($value)
    {
        if (Validator::validateImageFile($value, 1000, 1000)) {
            $this->foto_usuario = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setGenero($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_genero = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_estado = $value;
            return true;
        }else {
            return false;
        }
    }

    public function setCargo($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_cargo = $value;
            return true;
        }else {
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

    public function getNombres()
    {
        return $this->nombres_usuario;
    }

    public function getApellidos()
    {
        return $this->apellidos_usuario;
    }


    public function getAlias()
    {
        return $this->alias_usuario;
    }

    public function getClave()
    {
        return $this->clave_usuario;
    }

    public function getImagen()
    {
        return $this->foto_usuario;
    }

    public function getCorreo()
    {
        return $this->correo_usuario;
    }

    public function getRutaImagen()
    {
        return $this->ruta_imagen;
    }
    public function getCargo(){

        return $this->id_cargo;
    }

    public function getEstado(){

        return $this->id_estado;
    }
}
