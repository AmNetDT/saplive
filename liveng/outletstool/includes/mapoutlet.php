<?php 

try{
class MapOutlet{

    protected $message = array();
    
    public function getMessages(){
        return $this->message;
    }

    public function connect(){
        $servername = "91.109.247.182";
        $username = "mtrader";
        $password = "gtXeAg0dtBB!";
        $db = 'mobiletrader';
        $conn = new mysqli($servername, $username, $password, $db);
        
        return $conn;
    
    }//connect

    public function getEmployeeID($pin, $pass){
        $sql = "SELECT employee_id FROM users WHERE username = '$pass' AND password = '$pin' LIMIT 1";
        if($result = @$this->connect('mobiletrader')->query($sql)){
                
        }
    }

    public function getOutlets($employee_id){
        $sql = "SELECT COUNT(*) FROM employee_outlet WHERE employee_id = ?";
        $conn = $this->connect();
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('i',$employee_id);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->store_result();
        $stmt->fetch();
        if(!$stmt->num_rows > 0){
            return $stmt->error;
        }else{
            return $count;
        }
        //$stmt->free_result();
        
    }

    public function createOutlets($employee_id, $outstandingOutlets){
        //check if there are outlets already
        $data1 = $data2 = 0;
        if($this->getOutlets($employee_id) > 0){
            $sql = "SELECT start_date, end_date FROM employee_outlet WHERE employee_id = '$employee_id' LIMIT 1";
            if($result = @$this->connect('mobiletrader')->query($sql)){
                $row = $result->fetch_assoc();
                $data1 = $row['start_date'];
                $data2 = $row['end_date'];
                

                for($i = 0; $i < $outstandingOutlets; $i++){
                    $sql = "INSERT INTO employee_outlet (employee_id, outlet_id, call_week, start_date, end_date, status) 
                    VALUES ('$employee_id', NULL, NULL, $data1, $data2, NULL)";
                    if($result = @$this->connect('mobiletrader')->query($sql)){
                        $stat = true;
                    }else{
                        $stat = false;
                    }
    
                    if($i == ($outstandingOutlets - 1)){
                        if($stat){
                            return "<b>Operation Completed</b>";
                        }else{
                            return "<b>An Error Occurred</b>";
                        }
                    }
                }//for
            }else{
                return $result->error;
            }
            
            
        }else{
            //no outlets, populate afresh
            $date = date('Y-m-d h:i:s');
            for($i = 0; $i < $outstandingOutlets; $i++){
                $sql = "INSERT INTO employee_outlet (employee_id, outlet_id, call_week, start_date, end_date, status) 
                VALUES ('".$employee_id."', NULL, NULL, '".$date."', '".$date."', NULL)";
                if($result = @$this->connect('mobiletrader')->query($sql)){
                    $stat = true;
                }else{
                    $stat = false;
                }

                if($i == ($outstandingOutlets - 1)){
                    if($stat){
                        return "<b>Operation Completed</b>";
                    }else{
                        return "<b>An Error Occurred</b>";
                    }
                }
            }
        }
    }
}

}catch(Exception $e){
    echo 'An Error Occurred (Class)';            
}

?>