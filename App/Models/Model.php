<?php

namespace App\Models;

use PDO;

class Model
{
    private $dbServer = "localhost";
    private $username = "root";
    private $password = "";
    private $dbName = "authentication";

    protected function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->dbServer;dbname=$this->dbName", $this->username, $this->password);
            // set the PDO fetch mode to assoc
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            //For error displaying SQL errors uncomment line below
            //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
          } catch(PDOException $e) {
            echo "Nepavyko pasiekti duomenų bazės: " . $e->getMessage();
          }
    }
}
