<?php

class DB{

    private static $db_connection;
    protected static $instance = null;

    public function __construct($host, $dbname, $user, $password){
        if (is_null(self::$instance)){
            try{
                self::$db_connection = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
                self::$db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e){
                echo 'Connection failed: '.$e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function query($sql)
    {
        return self::$db_connection->query($sql);
    }

    public static function prepare($sql)
    {
        return self::$db_connection->prepare($sql);
    }

    public static function execute($query)
    {
        return self::$db_connection->exec($query);
    }

    public static function run($query, $args = [])
    {
        try
        {
            if (!$args)
            {
                return self::query($query);
            }
            $query = self::prepare($query);
            $query->execute($args);
            return $query;
        }
        catch (PDOException $e)
        {
            echo 'run sql failed: '.$e->getMessage();
        }
    }



    public static function getRows($sql, $args = [])
    {
        return self::run($sql, $args)->fetchAll();
    }

    public static function  sql($sql, $args = [])
    {
        return self::run($sql, $args);
    }

    public static function  sql_returned_rows($sql, $args = [])
    {
        $result = self::run($sql, $args);
        return [$result, $result->rowCount()];
    }
}





