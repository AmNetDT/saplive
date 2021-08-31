<?php 

class db{

    private $serverhost;
    private $dbUser;
    private $dbPass; 
    private $dbName; 
    private $dbport; 
    private $conn;
   
    function __construct(){

       $ini_array = parse_ini_file('config.ini',true); 
       $this->serverhost = $ini_array['database']['serverhost'];
       $this->dbUser = $ini_array['database']['username'];
       $this->dbPass = $ini_array['database']['password'];
       $this->dbName = $ini_array['database']['dbname'];
       $this->dbport = $ini_array['database']['port'];

    }
    
    public function connect(){
            $this->conn  = new mysqli($this->serverhost,$this->dbUser,$this->dbPass,$this->dbName,$this->dbport);
            return $this->conn;
    }
   
}  
?>