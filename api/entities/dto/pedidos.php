<?php
require_once('../../helpers/validator.php');
require_once('../../entities/dao/pedidos_queries.php');

class Pedido extends PedidoQueries
{
    protected $id_pedido = null; // detalle pedido
    protected $id_detalle_pedido = null; // detalle pedidos
    protected $cliente = null; // pedidos
    protected $producto = null; // detalle pedidos
    protected $cantidad = null; // detalle pedidos
    protected $precio = null; // detalle pedidos
    protected $estado = null; // pedido Valor por defecto en la base de datos: Pendiente

    public function setIdPedido($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setIdDetalle($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_detalle_pedido = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setProducto($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->producto = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            return false;
        }
    }

    public function setEstado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->estado = $value;
            return true;
        } else {
            return false;
        }
    }

    /*
    *   Métodos para obtener valores de los atributos.
    */
    
    public function getIdPedido()
    {
        return $this->id_pedido;
    }
 
}