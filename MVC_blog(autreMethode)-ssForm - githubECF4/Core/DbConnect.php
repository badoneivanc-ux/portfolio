<?php

namespace App\Core;

use PDO;
use Exception;

class DbConnect
{
    protected $connection;
    protected $request;

    public function __construct()
    {
        // Lecture des variables d'environnement Docker (définies dans docker-compose.yml)
        // Si absent (environnement MAMP local), on utilise les valeurs par défaut
        $host     = getenv('DB_HOST')     ?: '127.0.0.1';
        $port     = getenv('DB_PORT')     ?: '8889';
        $dbname   = getenv('DB_NAME')     ?: 'Portfolio';
        $user     = getenv('DB_USER')     ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'root';

        try {
            // Construction du DSN (Data Source Name) PDO avec host, port et dbname
            $this->connection = new PDO(
                'mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname,
                $user,
                $password
            );

            // Activation des erreurs PDO
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Les retours de requête seront en Tableau objet par défaut
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            // Encodage des caractères spéciaux en "utf8"
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
