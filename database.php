<?php

  //create a Database class that will hadle database connections

  class Database
  {
    //basic inits
    private $servername ='localhost';
    private $username ='root';
    private $password = '';
    private $db_name = 'php_api';

    //connection method
    function dbConnection()
    {
      try {

        $conn = new PDO("mysql:host=" . $this->servername . ";dbname=" . $this->db_name, $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;


      } catch (PDOException $e) {
        echo "connection error". $e->getMessage();
        exit;

      }

    }
  }



  
 ?>
