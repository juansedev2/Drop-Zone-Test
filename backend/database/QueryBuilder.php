<?php
/**
 * This class is the QueryBuilder of the app that makes the queries with the DB
*/
class QueryBuilder{
    /***
     * The constructor gets a pdo connection
     * @param $pdo is the pdo connection
    */
    public function __construct(private ?PDO $pdo){}

    /**
     * This function close manually the pdo connection of the currently QueyBuilder instance
    */
    public function __destruct(){
        $this->pdo = null;
    }

    /**
     * This function validte if the pdo proprety is null (to validate the state of the connection)
     * @return bool true if the connection is active, else return false
    */
    private function validatePDO(){
        return $this->pdo != null;
    }

     // CRUD OPERATIONS
    
    /**
     * This function gets all (SELECT ALL) of the records and all his data according of a table name, if any record exists, then return it in a associate array, else return null
     * @param string $table_name is the name of the table in the database
     * @return array|null return an array associative that contain each record, else, return null in case of failed or if any record exists
    */
    public function selectAll(string $table_name): Array | null{

        if(!$this->validatePDO()){
            return null;
        }
        
        try {
            $query = $this->pdo->prepare("select * from {$table_name}");
            $result = $query->execute();
            if($result){
                $result = $query->fetchAll(PDO::FETCH_ASSOC); // Is better get an associative array of each record
            }
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return null;
        }
        // https://www.php.net/manual/es/pdo.connections.php
        // This doc says that PHP will close the connections automatically when the script ends, also is possible do it to reference the variable to null (pdo and stat)
    }

    // INSERT
    /**
     * This function INSERT a new record on a table, returns a bool acording the result of the operation
     * @param string $table_name is the name of the table in the database
     * @param array $data is the associative array that must contains the name of the fields and his values to make the insert operation
     * @return bool true if the operations was succesful, else return false
    */
    public function create(string $table_name, array $data): bool{

        if(!$this->validatePDO()){
            return false;
        }

        // Get the fields names and the values of the table
        $fields = implode(", ", array_keys($data));
        $values = array_values($data);
        $wildcards = implode(", ", array_fill(0, count($values), "?")); // Generate the wildcards according the number of the fields to give values

        try {
            $query = $this->pdo->prepare("insert into {$table_name} ({$fields}) values ($wildcards)");
            $result = $query->execute($values);
            $query->closeCursor();
            return $result;
        } catch (PDOException $error) {
            //echo "<b> ¡Error!: " . $e->getMessage() . "<b/>";
            return false;
        }
    }



}