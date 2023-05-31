<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *   Método para verificar el alias de los usuarios
    *   Parámetros: $alias (nombre del usuario que se desea consultar)
    *   Retorno: booleano (true si el usuario es correcto o false en caso contrario).
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
    /*
    *  Métodos para gestionar la cuenta del usuario. password_verify
    *  Parámetros: $password(contraseña del usuario que se desea verificar)
    *  Retorno: booleano (true si la contraseña es correcta o false en caso contrario) 
    */
    public function checkPassword($password)
    {
        $sql = 'SELECT clave_usuario FROM usuarios WHERE id_usuario = ?';
        $params = array($this->id);
        $data = Database::getRow($sql, $params);
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
        } else {
            return false;
        }
    }

    /*

    public function changePassword()
    {
        $sql = 'UPDATE usuarios SET clave_usuario = ? WHERE id_usuario = ?';
        $params = array($this->clave_usuario, $_SESSION['id_usuario']);
        return Database::executeRow($sql, $params);
    }
    */
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

    /*
    * Método para buscar por medio de datos de un usuario
    */
    public function searchRows($value)
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, genero, cargo, estado_usuario, foto_usuario
                FROM usuarios
                INNER JOIN estado_usuarios USING(id_estado_usuario)
                INNER JOIN cargos  USING (id_cargo)
                INNER JOIN generos  USING (id_genero)
                WHERE nombre_usuario ILIKE ? OR apellido_usuario ILIKE ? OR correo_usuario ILIKE ? OR alias_usuario ILIKE ? OR genero ILIKE ? OR cargo ILIKE ? OR estado_usuario ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }
    /*
    * Método para crear un usuario
    */
    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, foto_usuario, id_cargo, id_genero, id_estado_usuario)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres_usuario, $this->apellidos_usuario, $this->correo_usuario, $this->alias_usuario, $this->clave_usuario, $this->foto_usuario, $this->id_cargo, $this->id_genero, $this->id_estado);
        return Database::executeRow($sql, $params);
    }
    /*
    public function readAllGenero()
    {
        $sql = 'SELECT id_genero, genero
        FROM generos
        ORDER BY id_genero';
        return Database::getRows($sql);
    }
    */

    /*
    public function readAllEstado()
    {
        $sql = 'SELECT id_estado_usuario, estado_usuario
        FROM estado_usuarios
        ORDER BY id_estado_usuario';
        return Database::getRows($sql);
    }
    */
    /*
    * Método para traer los registros de la base de datos.
    */
    public function readAll()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, cargo, genero, estado_usuario, foto_usuario
        FROM usuarios
        INNER JOIN estado_usuarios USING(id_estado_usuario)
        INNER JOIN cargos  USING (id_cargo)
        INNER JOIN generos  USING (id_genero)';

        return Database::getRows($sql);
    }
    /*
    * Método para traer un registro de la base de datos.
    */
    public function readOne()
    {
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, cargo, genero, estado_usuario, foto_usuario, id_genero, id_cargo, id_estado_usuario
                FROM usuarios
                INNER JOIN estado_usuarios USING(id_estado_usuario)
                INNER JOIN cargos  USING (id_cargo)
                INNER JOIN generos  USING (id_genero) 
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    /*
    * Método para actuazalizar un registro 
    */
    public function updateRow($current_image)
    {
        ($this->foto_usuario) ? Validator::deleteFile($this->getRutaImagen(), $current_image) : $this->foto_usuario = $current_image;

        $sql = 'UPDATE usuarios 
        SET foto_usuario = ?, nombre_usuario = ?, apellido_usuario = ?, correo_usuario = ?, alias_usuario = ?, clave_usuario = ?, id_genero = ?, id_cargo = ?, id_estado_usuario = ? 
        WHERE id_usuario = ?';
        $params = array($this->foto_usuario, $this->nombres_usuario, $this->apellidos_usuario, $this->correo_usuario, $this->alias_usuario, $this->clave_usuario, $this->id_genero, $this->id_cargo, $this->id_estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM usuarios
                WHERE id_usuario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
    /*
    * Método para evitar que el primer usuario no puede ser eliminado
    */
    public function firstuser()
    {
        $sql = 'SELECT id_usuario
                FROM usuarios
                ORDER BY id_usuario ASC LIMIT 1';
        $params = null;
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            return true;
        } else {
            return false;
        }
    }
}
