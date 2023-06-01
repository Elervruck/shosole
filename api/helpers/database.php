<?php
header('Access-Control-Allow-Origin: *');
require_once('config.php');

class Database
{
   
    private static $connection = null;
    private static $statement = null;
    private static $error = null;

    public static function executeRow($query, $values)
    {
        try {
            //Conexión de la clase PDO se encarga de mantener la conexión a la base de datos.
            self::$connection = new PDO('pgsql:host=' . SERVER . ';dbname=' . DATABASE . ';port=5432', USERNAME, PASSWORD);
            //Prueba para verificar si la conexión a la base de datos tuvo exitos.
            //print('Conectado');
            // Se prepara la se//ntencia SQL.
            self::$statement = self::$connection->prepare($query);
            // Se ejecuta la sentencia preparada y se retorna el resultado.
            return self::$statement->execute($values);
        } catch (PDOException $error) {
            // Se obtiene el código y el mensaje de la excepción para establecer un error personalizado.
            self::setException($error->getCode(), $error->getMessage());
            return false;
            }
        }   

          /*
    *   Método para obtener el valor de la llave primaria del último registro insertado.
    *   Parámetros: $query (sentencia SQL) y $values (arreglo con los valores para la sentencia SQL).
    *   Retorno: numérico entero (último valor de la llave primaria si la sentencia se ejecuta satisfactoriamente o 0 en caso contrario).
    */

        public static function getLastRow($query, $values)
        {
            if (self::executeRow($query, $values)) {
                $id = self::$connection->lastInsertId();
            } else {
                $id = 0;
            }
            return $id;
        }

        public static function getRow($query, $values = null)
    {
        if (self::executeRow($query, $values)) {
            return self::$statement->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    
    /*
    *   Método para obtener todos los registros de una sentencia SQL tipo SELECT.
    *   Parámetros: $query (sentencia SQL) y $values (arreglo opcional con los valores para la sentencia SQL).
    *   Retorno: arreglo asociativo de los registros si la sentencia SQL se ejecuta satisfactoriamente o false en caso contrario.
    */
    public static function getRows($query, $values = null)
    {
        if (self::executeRow($query, $values)) {
            return self::$statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    /*
    *   Método para establecer un mensaje de error personalizado al ocurrir una excepción.
    *   Parámetros: $code (código del error) y $message (mensaje original del error).
    *   Retorno: ninguno.
    */
    private static function setException($code, $message)
    {
        // Se asigna el mensaje del error original por si se necesita.
        self::$error = $message . PHP_EOL;
        // Se compara el código del error para establecer un error personalizado.
        switch ($code) {
            case '7':
                //self::$error = 'Hubo un problema para conectar con el servidor';
                break;
            case '42703':
                //self::$error = 'El nombre de un campo desconocido';
                break;
            case '23505':
                self::$error = 'No puedes ingresar un dato unico';
                break;
            case '42P01':
                self::$error = 'Nombre de tabla desconocido';
                break;
            case '23503':
                //self::$error = 'Violación de llave foránea';
                break;
            case '23514':
                self::$error = 'Debes de poner un número mayor a 0';
                break;
            default:
                //self::$error = $message;
        }
    }

    /*
    *   Método para obtener un error personalizado cuando ocurre una excepción.
    *   Parámetros: ninguno.
    *   Retorno: error personalizado.
    */
    public static function getException()
    {
        return self::$error;
    }   
}

     
        //$sql = 'Select * from usuarios';
        //Database::executeRow($sql, null);

    

   
    

    