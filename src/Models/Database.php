<?php
namespace App\Models;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            // On récupère les variables d'environnement
            $host = $_ENV['DB_HOST'];  // Assurez-vous qu'il vaut 'db' dans .env
            $db   = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            // Construction du DSN PostgreSQL
            $dsn = "pgsql:host=$host;dbname=$db;";

            try {
                self::$instance = new PDO($dsn, $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
