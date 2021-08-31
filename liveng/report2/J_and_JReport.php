<?php

    require 'sendMailer.php';
    require 'recipents.php';

    $start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');//date('Y-m-d');
    $time_start = microtime(true);


  /***** EDIT BELOW LINES *****/
  $DB_Server = "91.109.247.182"; // MySQL Server
  $DB_Username = "mtrader"; // MySQL Username
  $DB_Password = "gtXeAg0dtBB!"; // MySQL Password
  $DB_DBName = "call_centre"; // MySQL Database Name
  //$DB_TBLName = "outlet_fee"; // MySQL Table Name
  $xls_filename = 'J_and_JReport'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name
   
  /***** DO NOT EDIT BELOW LINES *****/
  // Create MySQL connection

$sql = "SELECT 
(@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS 'SN',
(SELECT TIMEDIFF(a.rdate, a.call_starttime)) AS 'Call Duration',
a.contactname AS 'Contact Name',
a.urno AS 'urno',
a.region AS 'Region',
a.channel AS 'Channel',
a.depot AS 'Depot',
a.outlet_type_name AS 'Outlet Type',
a.outlet_class_name AS 'Outlet Class',
a.cust_no AS 'Customer No',
a.outletaddress AS 'Outlet Address',
a.contactphone AS 'Contact Phone',
a.outletname AS 'Outlet Name',
a.price AS 'Do You Know The Current Price Of Our Product?',
a.rebate AS 'Do You Know About Your Monthly Rebate?',
a.reward AS 'Do You Know About Your Reward?',
a.visit_your_outlets AS 'How Often Does Your Rep Visit Your Outlet?',
a.delivery AS 'Is There Any Shortage On Delivery Of Your Order?',
a.stock_order AS 'Why Have You Not Bought This Month?',
a.serve_better AS 'How Can We Serve You Better?',
a.feedback AS 'Feedback',
a.repname AS 'Rep Name',
a.action_taken AS 'Action Taken',
a.call_status AS 'Call Status',
a.rdate AS 'Date'
FROM ba_calls_update a
      WHERE a.sdate = '$start_dtt'
      and a.user_name = 'Asaolu Adebola'
      ORDER BY a.rdate
";

  $Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password) or die("Failed to connect to MySQL:<br />" . mysqli_error($Connect) . "<br />" . mysqli_errno($Connect));
  // Select database
  $Db = @mysqli_select_db($Connect, $DB_DBName) or die("Failed to select database:<br />" . mysqli_error($Connect). "<br />" . mysqli_errno($Connect));
  // Execute query
  $result = @mysqli_query($Connect, $sql) or die("Failed to execute query:<br />" . mysqli_error($Connect). "<br />" . mysqli_errno($Connect));
   
  // Header info settings
  header("Content-Type: application/xls");
  header("Content-Disposition: attachment; filename=$xls_filename");
  header("Pragma: no-cache");
  header("Expires: 0");
   
  /***** Start of Formatting for Excel *****/
  // Define separator (defines columns in excel &amp; tabs in word)
  $sep = "\t"; // tabbed character
   
  // Start of printing column names as names of MySQL fields
//   for ($i = 0; $i<mysqli_num_fields($result); $i++) {
//     echo mysqli_field_name($result, $i) . "\t";
//   }

  
  $headers = array("S/N","Call Duration","Contact Name","urno","Region","Channel","Depot",
                        "Outlet Type","Outlet Class","Customer No","Outlet Address","Contact Phone","Outlet Name",
                        "Do You Know The Current Price Of Our Product?","Do You Know About Your Monthly Rebate?","Do You Know About Your Reward?",
                        "How Often Does Your Rep Visit Your Outlet?", "There Any Shortage On Delivery Of Your Order?",
                      "Why Have You Not Bought This Month?", "How Can We Serve You Better", "Feedback", "Rep Name", "Action Taken",
                    "Call Status", "Date");
  foreach($headers as $columnsarray1){
    echo ucwords($columnsarray1). "\t";
  }

  print("\n");
  // End of printing column names
   
  // Start while loop to get data
  $in=1;
  while($row = mysqli_fetch_row($result))
  {
    $schema_insert = "";
    for($j=0; $j<mysqli_num_fields($result); $j++)
    {
      //set S/N
      if($j == 0){
        $row[$j] = $in;
      }

      if ($row[$j] != "") {
        $schema_insert .= "$row[$j]".$sep;
      }
      else {
        $schema_insert .= "".$sep;
      }
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";

    ++$in;
  }

  //get Recipients
  $cat = ""; //Enter category of recipients
  $rec = getRecipients($cat); //returns array

  //get Attachments
  $attachments = array();
  $attachments[0] = getenv("HOMEDRIVE") . getenv("HOMEPATH")."\Downloads\\".$xls_filename;

  //send mail
  Sendmail($rec,$attachments);
  

?>