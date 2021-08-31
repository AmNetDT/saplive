<?php 

class createOutlets{

    private $conn;
    private $u_response;


    function __construct(){

        require_once './db_config/db.php';
        require_once './utils/util.php';
        $db = new db();
        $this->conn = $db->connect();

    }

    public function implement($empid,$no,$response){
       
        $this->u_response =  $response;
        
        $sql = "SELECT start_date, end_date FROM employee_outlet WHERE employee_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $empid);
        $stmt->bind_result($startdate, $enddate);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if($stmt->num_rows > 0){
            $arrays["startdate"] = $startdate;
            $arrays['enddate']= $enddate;
        }

        //if theres outlets before
        if($arrays['startdate'] != ''){
            for($i = 0; $i < $no; $i++){
                $sql = "INSERT INTO employee_outlet (employee_id, outlet_id, call_week, start_date, end_date, status)
                VALUES (?,NULL,NULL,?,?,NULL)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('iss',$empid,$arrays["startdate"],$arrays['enddate']);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    $stat = true;
                }else{
                    $stat = false;
                }

                if($i == ($no - 1)){
                    if($stat){
                        $arrays["status"] = "<b>Operation Completed</b>";
                    }else{
                        $arrays["status"] = "<b>An Error Occurred</b>";
                    }
                }
            }//for
        }else{
            //no outlets, populate afresh
            $date = date('Y-m-d h:i:s');
            for($i = 0; $i < $no; $i++){
                $sql = "INSERT INTO employee_outlet (employee_id, outlet_id, call_week, start_date, end_date, status) 
                VALUES (?, NULL, NULL, ?, ?, NULL)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param('iss', $empid, $date, $date);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                    $stat = true;
                }else{
                    $stat = false;
                }

                if($i == ($no - 1)){
                    if($stat){
                        $arrays["status"] = "<b>Operation Completed</b>";
                        
                    }else{
                        $arrays["status"] = "<b>An Error Occurred</b>";
                    }
                }
            }
        }

        return $this->u_response
            ->withHeader('Content-Type', 'application/json')
            ->write(json_encode($arrays));

    }
}

?>
