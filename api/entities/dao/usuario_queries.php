<?php
require_once('../../helpers/database.php');
/*
*	Clase para manejar el acceso a datos de la entidad USUARIO.
*/
class UsuarioQueries
{
    /*
    *  Métodos para gestionar la cuenta del usuario. password_verify
    */



    public function checkUser($alias)
    {
        $sql = 'SELECT id_usuario, estado_usuarios FROM usuarios WHERE alias_usuario = ?';
        $params = array($alias);
        if ($data = Database::getRow($sql, $params)) {
            $this->id = $data['id_usuario'];
            $this->estado = $data['estado_usuarios'];
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
        if (password_verify($password, $data['clave_usuario'])) {
            return true;
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
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, genero, cargo, estado_usuario, foto_usuario
                FROM usuarios
                INNER JOIN estado_usuarios USING(id_estado_usuario)
                INNER JOIN cargos  USING (id_cargo)
                INNER JOIN generos  USING (id_genero)
                WHERE nombre_usuario ILIKE ? OR apellido_usuario ILIKE ? OR correo_usuario ILIKE ? OR alias_usuario ILIKE ? OR genero ILIKE ? OR cargo ILIKE ? OR estado_usuario ILIKE ?';
        $params = array("%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%", "%$value%");
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO usuarios(nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, foto_usuario, id_cargo, generos_usuarios, estado_usuarios)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombres_usuario, $this->apellidos_usuario, $this->correo_usuario, $this->alias_usuario, $this->clave_usuario, $this->foto_usuario, $this->id_cargo, $this->id_genero, $this->estado);
        return Database::executeRow($sql, $params);
    }

    public function readAllGenero()
    {
        $sql = 'SELECT id_genero, genero
        FROM generos
        ORDER BY id_genero';
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
        $sql = 'SELECT id_usuario, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, cargo, generos_usuarios, generos_usuarios, foto_usuario, estado_usuarios
        FROM usuarios
        INNER JOIN cargos  USING (id_cargo)';

        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT generos_usuarios, estado_usuarios, nombre_usuario, apellido_usuario, correo_usuario, alias_usuario, clave_usuario, foto_usuario, cargos.cargo
                FROM usuarios
                INNER JOIN cargos ON usuarios.id_cargo = cargos.id_cargo
                WHERE id_usuario = ?;';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

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
    //Seleccionar el pirmer usuario y que por ende no pueda eliminarlo
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
    

    public function usuariosReport()
    {
        $sql = 'SELECT nombre_usuario, apellido_usuario, alias_usuario, generos_usuarios, estado_usuarios
                FROM usuarios
                INNER JOIN cargos USING(id_cargo)
                WHERE id_cargo = ?
                ORDER BY nombre_usuario';
        $params = array($this->id_cargo);
        return Database::getRows($sql, $params);
    }

    public function usuariosCargo()
    {
        $sql = "SELECT nombre_usuario, apellido_usuario, generos_usuarios, estado_usuarios
                FROM usuarios
                INNER JOIN cargos USING(id_cargo)
                WHERE id_cargo = ?
                ORDER BY nombre_usuario";
        $params = array($this->id_cargo);
        return Database::getRows($sql, $params); 
    }

    public function usuariosCargos()
    {
        $sql = 'SELECT nombre_usuario, apellido_usuario, alias_usuario, generos_usuarios
                FROM usuarios
                INNER JOIN cargos USING(id_cargo)
                WHERE id_cargo = ?
                ORDER BY nombre_usuario';
        $params = array($this->id_cargo);
        return Database::getRows($sql, $params);
    }
}
