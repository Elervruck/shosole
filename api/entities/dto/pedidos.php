<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');

class Pedido extends PedidoQueries
{
    protected $id = null;
    protected $estado_pedido = null;
    protected $fecha_pedido = null;
    protected $direccion_pedido = null;
    protected $cliente = null;
    protected $iddetalle = null;
    protected $producto = null;
    protected $cantidad = null;


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

    //Metodo para validar detalle
    public function setIddetalle($value)
    {
        if(Validator::validateNaturalNumber($value)){
            $this->iddetalle = $value;
            return true;
        } else{
            return false;
        }
    }

    //Metodo para validar estado del pedido
    public function setEstadoPedido($value)
    {
        if (Validator::validateBoolean($value)) {
            $this->estado_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar fehca de pedido
    public function setFechaPedido($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    //Metodo para validar direccion del pedido
    public function setDireccionPedido($value)
    {
        if (Validator::validateString($value, 1, 200)) {
            $this->direccion_pedido = $value;
            return true;
        } else {
            return false;
        } 
    }

    //Metodo para validar cliente
    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar producto
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar producto
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

<<<<<<< HEAD
<<<<<<< HEAD
    //Metodo para validar cantidad
=======
>>>>>>> 0b7af83c867e0e03db9984dde0ab5ae203cd0468
=======
    //Metodo para validar cantidad
>>>>>>> f74978697aaa965424c41fc70fb9e5c335b8738b
    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }


    public function getId()
    {
        return $this->id;
    }

    public function getEstadoPedido()
    {
        return $this->estado_pedido;
    }

    public function getDireccionPedido()
    {
        return $this->direccion_pedido;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getCliente()
    {
        return $this->cliente;
    }
    public function getIddetalle()
    {
        return $this->iddetalle;
    }
 
}