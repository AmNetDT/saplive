<?php

    require 'sendMailer.php';
    require 'recipents.php';

    $start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');//date('Y-m-d');
    $time_start = microtime(true);


  /***** EDIT BELOW LINES *****/
  $DB_Server = "91.109.247.182"; // MySQL Server
  $DB_Username = "mtrader"; // MySQL Username
  $DB_Password = "gtXeAg0dtBB!"; // MySQL Password
  $DB_DBName = "mobiletrader"; // MySQL Database Name
  $DB_TBLName = "outlet_feedback"; // MySQL Table Name
  $xls_filename = 'Tobacco_Call_Center_Summary_SE'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name
   
  /***** DO NOT EDIT BELOW LINES *****/
  // Create MySQL connection

$sql = "SELECT (@cnt := if(@cnt IS NULL, 0,  @cnt) + 1) AS SN,
c.name AS Channels,
 i.name AS Region, 
 b.urNo AS customer_code, 
 b.outletName AS customer_name,
 b.outletAddress AS customer_address, 
 b.contactPhone AS customer_phone, 
 (SELECT CONCAT(last_name,' ',first_name) FROM employees WHERE id = e.employee_id) AS rep_name,
h.name AS customer_location,
visit_freq,
tlp_use, 
competition_sell, 
service_rate, 
serve_better, 
DATE_FORMAT(a.entry_time,'%r') AS call_time,
CONCAT(d.last_name,' ',d.first_name) AS cc_agent 
FROM outlet_feedback a, outlets b, vehicles c, employees d, employee_outlet e, employee_division f, divisions_map g, depots h, regions i
WHERE 
a.outlet_id = b.id 
AND a.vehicles_id = c.id
AND a.employee_id = d.id
AND b.id = e.outlet_id 
AND e.end_date LIKE '0000-00-00 00:00:00'
AND e.employee_id = f.employee_id 
AND f.end_date LIKE '0000-00-00 00:00:00'
AND f.division_map_id = g.id 
AND g.depot_id = h.id
AND g.region_id = i.id
AND a.entry_time BETWEEN '$start_dtt' AND DATE_ADD('$end_dtt',INTERVAL 1 DAY)
AND a.employee_id = '3318'         
ORDER BY a.entry_time
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

  
  $headers = array("S/N","Channels","Region","Customer Codes","Customer Names","Address","Phone No.",
                        "Rep Name","Depot","Rep Visit","Used Last TLP","Selling Competition","How Do You Rate Our Service",
                        "How Do We Serve You Better","Time","Agent");
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