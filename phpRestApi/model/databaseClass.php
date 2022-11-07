<?php
header('Access-Control-Allow-Origin: *'); 
class Database
{
    protected $connection = null;
    
    //Constructs a connection to the DB
    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
         
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }           
    }
 
    //General function to execute a SELECT statement for selecting DB documents
    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);               
            $stmt->close();
            // print($query);
            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    //General function to execute a INSERT statement for Inserting DB documents
    public function insert($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            if ($stmt == true){
               //Statement was successful
                $result = $stmt->insert_id;
                return $result;
                $stmt->close();
            }
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

        //General function to execute a INSERT statement for Inserting DB documents
        public function update($query = "" , $params = [])
        {
            try {
                $stmt = $this->executeStatement( $query , $params );
                if ($stmt == true){
                   //Statement was successful
                    // $result = $stmt->insert_id;
                    return $stmt;
                    $stmt->close();
                }
            } catch(Exception $e) {
                throw New Exception( $e->getMessage() );
            }
            return false;
        }
 
    //Function/helper used to execute a chosen query on the db
    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
 
            if($stmt === false) {
                throw New Exception("Unable to do prepared statement: " . $query);
            }
            // print_r($params);
            if( $params ) {
                $stmt->bind_param(...$params);
            }

            $stmt->execute();
 
            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }   
    }
}