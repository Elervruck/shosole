<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dashboard/dao/cliente_queries.php');
/*
*	Clase para manejar la transferencia de datos de la entidad USUARIO.
*/
class Clientes extends ClientesQueries
{
    // Declaración de atributos (propiedades).
    protected $id = null;
    protected $nombre_cliente = null;
    protected $apellido_cliente = null;
    protected $dui_cliente = null;
    protected $correo_cliente = null;
    protected $telefono_cliente = null;
    protected $nacimiento_cliente = null;
    protected $direccion_cliente = null;
    protected $clave_cliente = null;
    protected $estado_cliente = null;
    protected $genero_clientes = null;
    protected $foto_cliente = null;
    protected $usuario_cliente = null;
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

    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setApellido($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellido_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDui($value)
    {
        if (Validator::validateDUI($value)) {
            $this->dui_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setImagen($value)
    {
        if (Validator::validateImageFile($value, 1000, 1000)) {
            $this->foto_cliente = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setNacimiento($value)
    {
        if (Validator::validateDate($value, 1, 50)) {
            $this->nacimiento_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setDireccion($value)
    {
        if (Validator::validateString($value,1, 250)) {
            $this->direccion_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave_cliente = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }


    public function setEstadoCliente($value)
    {
        if (Validator::validateAlphabetic($value, 1, 10)) {
            $this->estado_cliente = $value;
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

    public function setUsuario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->usuario_cliente = $value;
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

   public function getNombre()
   {
       return $this->nombre_cliente;
   }

   public function getApellido()
   {
       return $this->apellido_cliente;
   }

   public function getDui()
   {
       return $this->dui_cliente;
   }

   public function getCorreo()
   {
       return $this->correo_cliente;
   }

   public function getTelefono()
   {
       return $this->telefono_cliente;
   }

   public function getNacimiento()
   {
       return $this->nacimiento_cliente;
   }

   public function getDireccion()
   {
       return $this->direccion_cliente;
   }

   public function getClave()
   {
       return $this->clave_cliente;
   }

   public function getEstadoCliente()
   {
       return $this->estado_cliente;
   }

   public function getGenero()
   {
       return $this->id_genero;
   }

   public function getUsuario(){

    return $this->id_estado_cliente;
}

   public function getFoto(){

    return $this->foto_cliente;
    }

    public function getEstado(){

        return $this->id_estado_cliente;
    }

   public function getRutaImagen()
   {
       return $this->ruta_imagen;
   }

   }