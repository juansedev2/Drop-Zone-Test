<?php
/**
 * This class represents the database connection
*/
class DBConnection{

    private string $sgbd = "pgsql";
    private string $host = "127.0.0.1";
    private string $port = "5432";
    private string $database_name = "DropZoneDB";
    private string $user = "postgres";
    private string $password = "root";
    private ?PDO $connection = null;

    /**
     * This function try the connection with the database, if it's succesful, return an PDO object, else, return null
     * @param array $config is the array that contains the paramertes to do the connection
     * @return PDO|null return a PDO object if the connections is succesful, else, return null
    */
    public function __construct(){

        /* if($this->connection instanceof PDO){
            echo "<h1>Ya hay una conexión</h1>";
            return $this->connection;
        } */

        try {
            $pdo = new PDO("{$this->sgbd}: host={$this->host};port={$this->port};dbname={$this->database_name}", "{$this->user}", "{$this->password}");
            // echo "<h1>Conexión exitosa!</h1>";
            $this->connection = $pdo;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $error->getMessage() . "<b/>";
            $this->connection = null;
        }
    }

    public function getPDO() : PDO | bool{
        if($this->connection instanceof PDO){
            return $this->connection;
        }else{
            return false;
        }
    }

    /**
     * This function CLOSE manually a PDO conection by reference
     * @param PDO $pdo by reference is the PDO instance to will be closed
    */
    public function CloseConnection(): void{
        $this->connection = null;
    }
}