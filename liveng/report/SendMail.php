<?php

	require_once 'mail/Swift_mail/lib/swift_required.php';
	
	function sendMail($file_name, $unit, $rec){
		
		
		
		$host = 'secure.emailsrvr.com';
        $port = 587;
		$user = 'mobiletrader@greatbrandsng.com';
		$usnm = 'Mobiletrader';
		$pwd = 'P@ssword' ;
        $transport = Swift_SmtpTransport::newInstance($host, $port);
        $transport->setUsername($user);
        $transport->setPassword($pwd);
        $mailer = Swift_Mailer::newInstance($transport); 
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));              
        $subject = "$unit--Call Summary";        
        $msg = Swift_Message::newInstance();
        $msg->setSubject($subject);
        $msg->setFrom('mobiletrader@greatbrandsng.com');
        $msg->setContentType("text/html");        
        $msg->attach(Swift_Attachment::fromPath($file_name,'application/vnd.ms-excel'));  
		$emails = getRecipients($rec);
        $msg->setTo($emails);
        //$msg->setReadReceiptTo($cc);      
        $message = "
                       <p>Dear All,</p><p></p><br><br>
						Please,  find attached the <b>Call Center Summary for the $unit</b> for today.</p><br><br>
						<p>Regards,</p><br><br>
						<p><b>Mobile Trader</b></p>";
                     
        $msg->setBody($message); 
		$failures = 'log.txt';
        if($mailer->send($msg, $failures)){
            echo 'sent!';
           return true;
        }else print_r($failures);
		echo '<br>concluded<br>';
    }
	
	
	function sendMail3($message, $rec){
		
		$host = 'secure.emailsrvr.com';
        $port = 587;
		$user = 'mobiletrader@greatbrandsng.com';
		$usnm = 'Mobiletrader';
		$pwd = 'P@ssword' ;
        $transport = Swift_SmtpTransport::newInstance($host, $port);
        $transport->setUsername($user);
        $transport->setPassword($pwd);
        $mailer = Swift_Mailer::newInstance($transport); 
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));              
        $subject = "Escalated Mail from the CRO";        
        $msg = Swift_Message::newInstance();
        $msg->setSubject($subject);
        $msg->setFrom('mobiletrader@greatbrandsng');
        //$msg->setContentType("text/html");        
        $emails = getRecipients($rec);
        $msg->setTo($emails);
        //$msg->setReadReceiptTo($cc);      
        $msg->setBody($message); 
		$failures = 'log.txt';
        if($mailer->send($msg, $failures)){
            return true;
        }else print_r($failures);
		echo '<br>concluded<br>';
		return false;
		
	}
	
	function sendMail2($file_name, $unit,$message, $rec){
		$host = 'secure.emailsrvr.com';
        $port = 587;
		$user = 'mobiletrader@greatbrandsng.com';
		$usnm = 'Mobiletrader';
		$pwd = 'P@ssword' ;
        $transport = Swift_SmtpTransport::newInstance($host, $port);
        $transport->setUsername($user);
        $transport->setPassword($pwd);
        $mailer = Swift_Mailer::newInstance($transport); 
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));              
        $subject = "$unit--Call Summary";        
        $msg = Swift_Message::newInstance();
        $msg->setSubject($subject);
        $msg->setFrom('mobiletrader@greatbrandsng');
        $msg->setContentType("text/html");        
        $msg->attach(Swift_Attachment::fromPath($file_name,'application/vnd.ms-excel'));  
		$emails = getRecipients($rec);
        $msg->setTo($emails);
        //$msg->setReadReceiptTo($cc);      
        $msg->setBody($message); 
		$failures = 'log.txt';
        if($mailer->send($msg, $failures)){
            echo 'sent!';
           return true;
        }else print_r($failures);
		echo '<br>concluded<br>';
    }
	
	function connect($db){
        $servername = "91.109.247.182";
        $username = "mtrader";
        $password = "gtXeAg0dtBB!";
        $conn = new mysqli($servername, $username, $password);
        $conn->select_db($db);
		return $conn;
	}
	
	function getRecipients($rec){ 
		$emails = array();
		$qry = "select email from recipients where category like '%|$rec|%'";
		if($result = connect('call_centre')->query($qry)){
            While($row = $result->fetch_row()){
				$emails[]  = $row[0];
			}
        }
		return $emails;//ails;
	}
	
?>