<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/valoraciones_queries.php');

class Valoracion extends ValoracionQueries

{
    protected $id = null;
    protected $estado = null;
    protected $comentario = null;
    protected $calificacion =null;
    protected $estado_comentario = null;
    protected $fecha = null;
    protected $id_detalle_pedido = null;
<<<<<<< HEAD
<<<<<<< HEAD

    //Metodo para validar id
=======
   

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======

    //Metodo para validar id
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar detalle del pedido
=======
    

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar detalle del pedido
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setIdDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar nombre
=======
    

>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar nombre
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setEstado($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar calificacion del producto
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar calificacion del producto
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setCalificacion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->calificacion = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar comentarios
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar comentarios
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setComentario($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->comentario = $value;
            return true;
        } else {
            return false;
        }
    }


    public function setEstadoComentario($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_comentario = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setFechaComenatrio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            return false;
        }
    }



    public function getId()
    {
        return $this->id;
    }

    public function getIdDetallePedido()
    {
        return $this->id_detalle_pedido;
    }


    public function getEstado()
    {
        return $this->estado;
    }

    public function getEstadoComentario()
    {
        return $this->estado_comentario;
    }

    public function getFechaComentario()
    {
        return $this->fecha;
    }

    public function getComentario()
    {
        return $this->comentario;
    }

    public function getCalificacion()
    {
        return $this->calificacion;
    }


}