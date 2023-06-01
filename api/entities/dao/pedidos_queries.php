<?php
require_once('../../helpers/database.php');

class PedidoQueries
{
    /*
    *   Métodos para realizar las operaciones de buscar(search) de pedido
    */

    
   

    public function readAllDetalle()
    {
        $sql = 'SELECT d.id_detalle_pedido, cli.nombre_cliente, pro.nombre_producto, d.cantidad_producto, d.precio_producto
        from detalle_pedidos d
        inner join productos pro USING (id_producto)
        inner join pedidos ped USING (id_pedido)
        inner join clientes cli USING (id_cliente)
        where id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

      // Método para verificar si existe un pedido en proceso para seguir comprando, de lo contrario se crea uno.
      public function startOrder()
      {
          $sql = "SELECT id_pedido
                  FROM pedidos
                  WHERE estados_pedidos = 'Pendiente' AND id_cliente = ?";
          $params = array($_SESSION['id_cliente']);
          
          if ($data = Database::getRow($sql, $params)) {
              $this->id = $data['id_pedido'];
              return true;
          } else {
              $sql = 'INSERT INTO pedidos(direccion_pedido, id_cliente)
                      VALUES((SELECT direccion_cliente FROM clientes WHERE id_cliente = ?), ?)';
              $params = array($_SESSION['id_cliente'], $_SESSION['id_cliente']);
              // Se obtiene el ultimo valor insertado en la llave primaria de la tabla pedidos.
              if ($this->id = Database::getLastRow($sql, $params)) {
                  return true;
              } else {
                  return false;
              }
          }
      }



    
    // Método para agregar un producto al carrito de compras.
    public function createDetail()
    {
        $sql = 'INSERT INTO detalle_pedidos(id_producto, precio_total, cantidad_producto, id_pedido)
        VALUES(?, (SELECT precio_producto FROM productos WHERE id_producto = ?), ?, ?)';
        $params = array($this->producto, $this->producto, $this->cantidad, $this->id);
        return Database::executeRow($sql, $params);
    }


      // Método para obtener los productos que se encuentran en el carrito de compras.
      public function readOrderDetail()
      {
          $sql = 'SELECT id_detalle_pedido, nombre_producto, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto
          from pedidos
          INNER JOIN detalle_pedidos USING(id_pedido) 
          INNER JOIN productos USING(id_producto) 
          where id_pedido = ?
          order by id_detalle_pedido, nombre_producto, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto';
          $params = array($this->id);
          return Database::getRows($sql, $params);
      }


    //   public function finishOrder()
    //   {
    //       // Se establece la zona horaria local para obtener la fecha del servidor.
    //       date_default_timezone_set('America/El_Salvador');
    //       $date = date('Y-m-d');
  
    //       $this->estado_pedido = 'Entregado' ;

    //       $sql = 'UPDATE pedidos
    //               SET estados_pedidos = ?, fecha_pedido = ?
    //               WHERE id_pedido = ?';
    //       $params = array($this->estado_pedido, $date, $_SESSION['id_pedido']);
    //       return Database::executeRow($sql, $params);
    //   }


//Método para cargar los pedidos del historial de compra
    public function cargarHistorial()
    {
        $sql = 'SELECT id_pedido, estados_pedido, fecha_pedido, direccion_pedido
        FROM pedidos
        INNER JOIN clientes USING(id_cliente)
        where id_cliente = ?';
       $params = array($this->id);
       return Database::getRows($sql, $params);
    }

//Metodo para ver los productos de cada pedido del cliente en sesion
    public function readVerCompra()
    {
        $sql = 'SELECT id_pedido, id_detalle_pedido, nombre_producto, detalle_pedidos.id_detalle_pedido, detalle_pedidos.precio_total, detalle_pedidos.cantidad_producto, productos.descripcion_producto, productos.imagen_producto, productos.condicion_producto, pedidos.estados_pedido 
        FROM pedidos
        INNER JOIN detalle_pedidos USING(id_pedido)
        INNER JOIN productos USING(id_producto) 
        WHERE id_pedido = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }


    
 
}



