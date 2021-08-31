<?php 

class employeeDetails{

    private $conn;
    private $u_response;


    function __construct(){

        require_once './db_config/db.php';
        require_once './utils/util.php';
        $db = new db();
        $this->conn = $db->connect();

    }

    public function implement($username,$pin,$response){
       
        $this->u_response =  $response;
        
        $sql = "SELECT employee_id FROM users WHERE username = ? AND password = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('si', $username,$pin);
        $stmt->bind_result($employee_id);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows > 0){
            $arrays["status"] = "200";
            $arrays["employee_id"] = "<p>Employee ID: ".$employee_id."</p>";
        }

        $sql = "SELECT COUNT(*) FROM employee_outlet WHERE employee_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $employee_id);
        $stmt->bind_result($noOfOutlets);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows > 0){
            $arrays["status"] = "200";
            $arrays["no_of_outlets"] = "<p>Number of Outlets: ".$noOfOutlets."</p>";
        }

        return $this->u_response
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($arrays));

    }
}

?>
