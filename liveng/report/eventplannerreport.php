<?php
	require "callcentre_template.php";

    $start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:'2018-07-24';//date('Y-m-d');
    
    $time_start = microtime(true);
	$file_name = "Event_Planner_Report$start_dtt.xls";
    $recipient = 'softwaredeveloper1.ho@greatbrandsng.com';
    $qry = "
            SELECT 
			(SELECT TIMEDIFF(a.rdate, a.call_starttime)),
			b.name,
            a.urno,
			a.you_are,
            a.partner_with_us,
            a.upcoming_event,
            a.product_requisition,
            a.event_plan_occurence,
            a.feedback,
            a.action_taken,
            a.data_validation,
            a.facebook,
            a.instagram,
            a.twitter,
            a.phone,
            a.email,
            a.call_status,
			a.rdate
            FROM event_planner_questions a, event_planner_details b
            WHERE a.urno= b.urno
			and sdate = '$start_dtt'
            ORDER BY rdate
        "; 
	$headers = array("S/N","call duration","name","Customer No","Who are you?","Do you want to partner with us?","Do you have any upcoming event?",
                        "Product requisition","How often do you plan events like this?","Feedback","action taken","data validation","facebook",
                        "instagram","twitter","phone","email","call status","Date");
    if(prepareExcel($file_name, $qry, $headers, 'Reports', 'Event Planner')){
		$recipient = 1;
		//sendMail($file_name, 'Event Planner', $recipient);
		sendMail3('This is paul','softwaredeveloper1.ho@greatbrandsng.com');
	}else echo "No call details to send on $start_dtt<br/>";
	$time_end = microtime(true); 
	$script_duration = round($time_end - $time_start,1); 
	echo "script concluded in $script_duration seconds.<br/>"; 
?>