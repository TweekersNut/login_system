<?php
/**
 * Author : Taranpreet Singh
 * PHPCLASSES Profile : https://www.phpclasses.org/browse/author/1466924.html
 * Want to get something developed ? Let's make it email at : taranpreet@taranpreetsingh.com 
 */
class DB{

    private $dbConnection = null;
    public $tbl = null;

    /**
     * Database Class constructor function which will read the database configuration from the global config array and create database
     * connection using PDO API.
     */
    function __construct(){
        try{
            $this->dbConnection = new PDO('mysql:host='.Config::get('db/host').';dbname='.Config::get('db/database'),Config::get('db/username'),Config::get('db/password'));
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(Exception $e){
           die($e->getMessage());
        }
        
    }

    /**
     * Return the connection for extra or custom query.
     * Type @PDO
     */
    public function getConnection() : PDO{
        return $this->dbConnection;
    }

    /**
     * 
     */

     public function setTbl($tblname){
        $this->tbl = $tblname;
     }

     /**
      * 
      */

      public function getTbl() : string{
          return $this->tbl;
      }

    /**
     * 
     */
    public function add($data = []) : bool {
        try{
            if(!is_null($this->tbl)){
                if (count($data)) {
                    $keys = array_keys($data);
                    $values = '';
                    $binder = 1;
                    foreach ($data as $field) {
                        $values .= '?';
                        if ($binder < count($data)) {
                            $values .= ', ';
                        }
                        $binder++;
                    }
                    $sqlQuery = "insert into `{$this->tbl}` (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
                    $query = $this->dbConnection->prepare($sqlQuery);
                    if ($query) {
                        $binder = 1;
                        foreach ($data as $para) {
                            $query->bindValue($binder, $para);
                            $binder++;
                        }
                        if ($query->execute()) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * 
     */
    public function lastInsertID() : int{
        return $this->dbConnection->lastInsertId();
    }

    /**
     * 
     */
    public function update($id, $fields) : bool {
        try{
            $set = '';
            $binder = 1;
            foreach ($fields as $name => $value) {
                $set .= "{$name} = ?";
                if ($binder < count($fields)) {
                    $set .= ', ';
                }
                $binder++;
            }
            $sqlQuery = "UPDATE {$this->getTbl()} SET {$set} WHERE id = {$id}";
            $query = $this->dbConnection->prepare($sqlQuery);
            if ($query) {
                $binder = 1;
                foreach ($fields as $para) {
                    $query->bindValue($binder, $para);
                    $binder++;
                }
                if ($query->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
        }catch(Exception $e){
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * 
     */
    public function delete($id) : bool {
        try {
            $sqlQuery = "delete from {$this->tbl} where id = :id";
            $remUser = $this->dbConnection->prepare($sqlQuery);
            if ($remUser->execute([':id' => $id])) {
                return true;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return false;
    }

    /**
     * Close and destroy connection variable.
     */
    function __destruct(){
        $this->dbConnection = null;
    }

    /**
     * Query Single
     */

     public function querySingle(string $sql,array $params){
        $result = $this->dbConnection->prepare($sql);
        if($result->execute($params)){
            return $result->fetch(PDO::FETCH_OBJ);
        }
        return false;
     }

     /**
      * Query Result Set
      */

      public function query(string $sql, array $params) : object{
          $result = $this->dbConnection->prepare($sql);
          if($result->execute($params)){
              return $result->fetchAll(PDO::FETCH_OBJ);
          }
      }


}