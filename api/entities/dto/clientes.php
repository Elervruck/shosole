<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/cliente_queries.php');
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
    const GENERO = array(
        array('Masculino', 'Masculino'),
        array('Femenino','Femenino')
    );
    const ESTADO = array(
        array('Activo', 'Activo'),
        array('Inactivo','Inactivo'),
        array('Desactivado','Desactivado')
    );
    protected $foto_cliente = null;
    protected $usuario_cliente = null;
    protected $ruta_imagen = '../../../images/clientes/';

    /*
    *   Métodos para validar y asignar valores de los atributos.
    */

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

    //Metodo para validar nombre
    public function setNombre($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->nombre_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar apellido
    public function setApellido($value)
    {
        if (Validator::validateAlphabetic($value, 1, 50)) {
            $this->apellido_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar dui
    public function setDui($value)
    {
        if (Validator::validateDUI($value)) {
            $this->dui_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar correo
    public function setCorreo($value)
    {
        if (Validator::validateEmail($value)) {
            $this->correo_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar imagen
    public function setImagen($value)
    {
        if (Validator::validateImageFile($value, 1000, 1000)) {
            $this->foto_cliente = Validator::getFileName();
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar telefono
    public function setTelefono($value)
    {
        if (Validator::validatePhone($value)) {
            $this->telefono_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar nacimiento
    public function setNacimiento($value)
    {
        if (Validator::validateDate($value, 1, 50)) {
            $this->nacimiento_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar direccion
    public function setDireccion($value)
    {
        if (Validator::validateString($value, 1, 250)) {
            $this->direccion_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar clave
    public function setClave($value)
    {
        if (Validator::validatePassword($value)) {
            $this->clave_cliente = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
    //Metodo para validar estaodo del cliente
    public function setEstadoCliente($value)
    {
        if (Validator::validateAlphabetic($value, 1, 10)) {
            $this->estado_cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar genero
    public function setGenero($value)
    {
        if (Validator::validateAlphabetic($value, 1, 10)) {
            $this->id_genero = $value;
            return true;
        } else {
            return false;
        }
    }
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    //Metodo para validar usuario
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
<<<<<<< HEAD
        return $this->estado_cliente;
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    }

    public function getGenero()
    {
<<<<<<< HEAD
        return $this->id_genero;
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    }

    public function getUsuario()
    {

        return $this->usuario_cliente;
    }

    public function getFoto()
    {

        return $this->foto_cliente;
    }

    public function getEstado()
    {

<<<<<<< HEAD
        return $this->estado_cliente;
=======
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    }

    public function getRutaImagen()
    {
        return $this->ruta_imagen;
    }
}
