<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Métodos para gestionar la cuenta del usuario. password_verify
    */
    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->alias = $alias;
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave_usuario'])) {            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave_usuario, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE id_usuario = ?';
        $params = array($_SESSION['id_usuario']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE usuarios
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?, alias_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres_usuario, $this->apellidos_usuario, $this->correo_usuario, $this->alias_usuario, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, delete).
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario
                FROM usuarios
                WHERE apellidos_usuario ILIKE ? OR nombres_usuario ILIKE ?
                ORDER BY apellidos_usuario';
        $params = array("%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, foto_usuario, id_cargo, id_genero, id_estado_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres_usuario, $this->apellidos_usuario, $this->correo_usuario, $this->alias_usuario, $this->clave_usuario, $this->foto_usuario, $this->id_cargo, $this->id_genero, $this->id_estado);
        return Database::executeRow($sql, $params);
    }

    public function readAllGenero()
    {
        $sql = 'SELECT id_genero, genero
        FROM generos
        ORDER BY id_genero';
        return Database::getRows($sql);
    }

    public function readAllCargo()
    {
        $sql = 'SELECT id_cargo, cargo
        FROM cargos
        ORDER BY id_cargo';
        return Database::getRows($sql);
    }

    public function readAllEstado()
    {
        $sql = 'SELECT id_estado_usuario, estado_usuario
        FROM estado_usuarios
        ORDER BY id_estado_usuario';
        return Database::getRows($sql);
    }

    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, alias_usuario, cargo, genero, estado_usuario, foto_usuario
        FROM usuarios
        INNER JOIN estado_usuarios USING(id_estado_usuario)
        INNER JOIN cargos  USING (id_cargo)
        INNER JOIN generos  USING (id_genero)';

        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombres_usuario, apellidos_usuario, correo_usuario, alias_usuario, cargo, genero, estado_usuario, foto_usuario, id_genero, id_cargo, id_estado_usuario
                FROM usuarios
                INNER JOIN estado_usuarios USING(id_estado_usuario)
                INNER JOIN cargos  USING (id_cargo)
                INNER JOIN generos  USING (id_genero) 
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE usuarios 
                SET nombres_usuario = ?, apellidos_usuario = ?, correo_usuario = ?
                WHERE id_usuario = ?';
        $params = array($this->nombres, $this->apellidos, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
