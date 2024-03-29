<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad CLIENTE.
*/
class ClientesQueries
{
    /*
    *   Métodos para gestionar la cuenta del clientes.
    */

    public function checkUser($usuario_cliente)
    {
        $sql = 'SELECT id_cliente, estado_cliente FROM clientes WHERE usuario_cliente = ?';
        $params = array($usuario_cliente);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_cliente'];
            $this->estado_cliente = $data['estado_cliente'];
            $this->usuario_cliente = $usuario_cliente;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_cliente FROM clientes WHERE id_cliente = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave_cliente'])) {
            return true;
        } else {
            return false;
        }
    }

    public function searchRows($value)
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, clave_cliente, estado_cliente, genero, foto_cliente, usuario_cliente
                FROM clientes
                INNER JOIN estado_clientes USING(id_estado_cliente)
                INNER JOIN generos  USING (id_genero)
                WHERE nombre_cliente ILIKE ? OR apellido_cliente ILIKE ? OR dui_cliente ILIKE ? OR correo_cliente ILIKE ? OR telefono_cliente ILIKE ? OR nacimiento_cliente::text ILIKE ? OR usuario_cliente ILIKE ? OR estado_cliente ILIKE ? OR genero ILIKE ?';
        $params = array("%$value%" , "%$value%" , "%$value%" , "%$value%" ,  "%$value%" , "%$value%" , "%$value%" , "%$value%" , "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO clientes(nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, clave_cliente, estado_cliente, id_genero, foto_cliente, usuario_cliente)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->nacimiento_cliente, $this->direccion_cliente, $this->clave_cliente, $this->estado_cliente, $this->id_genero, $this->foto_cliente, $this->usuario_cliente);
        return Database::executeRow($sql, $params);
    }

    public function crearCuenta(){
        $sql = "INSERT INTO  clientes(nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente,clave_cliente, usuario_cliente, estado_cliente)
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, 'Activo')";
        
        $params = array($this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->nacimiento_cliente, $this->clave_cliente, $this->usuario_cliente );
        return Database::executeRow($sql, $params);

    }

    public function readAllGenero()
    {
        $sql = 'SELECT id_genero, genero
        FROM generos
        ORDER BY id_genero';
        return Database::getRows($sql);
    }


    public function readAllEstadoCliente()
    {
        $sql = 'SELECT id_estado_cliente, estado_cliente
        FROM estado_clientes
        ORDER BY id_estado_cliente';
        return Database::getRows($sql);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, direccion_cliente, clave_cliente, estado_cliente, genero_clientes, foto_cliente, usuario_cliente, nacimiento_cliente
        FROM clientes';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente, direccion_cliente, clave_cliente, estado_cliente, genero_clientes, usuario_cliente, foto_cliente
                FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow($current_image)
    {
        ($this->foto_cliente) ? Validator::deleteFile($this->getRutaImagen(), $current_image) : $this->foto_cliente = $current_image;
        $sql = 'UPDATE clientes 
                SET foto_cliente = ?, nombre_cliente = ?, apellido_cliente =?, dui_cliente =?, correo_cliente =?, telefono_cliente =?, nacimiento_cliente =?, direccion_cliente =?,  id_estado_cliente =?, id_genero =?, usuario_cliente =?
                WHERE id_cliente = ?';
        $params = array($this->foto_cliente, $this->nombre_cliente, $this->apellido_cliente, $this->dui_cliente, $this->correo_cliente, $this->telefono_cliente, $this->nacimiento_cliente, $this->direccion_cliente, $this->id_estado_cliente, $this->id_genero, $this->usuario_cliente, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    
    public function cantidadPedidosCliente()
    {
        $sql = 'SELECT usuario_cliente, COUNT(id_pedido) pedidos
                FROM clientes
                INNER JOIN pedidos USING(id_cliente)
                GROUP BY usuario_cliente
                ORDER BY pedidos DESC LIMIT 5';
        return Database::getRows($sql);
    }

}
