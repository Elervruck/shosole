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
   

    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            return false;
        }
    }

    

    public function setIdDetallePedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    

    public function setEstado($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCalificacion($value)
    {
        if (Validator::validateAlphanumeric($value, 1, 50)) {
            $this->calificacion = $value;
            return true;
        } else {
            return false;
        }
    }

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