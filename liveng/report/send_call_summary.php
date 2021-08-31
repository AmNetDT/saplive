<?php 
 date_default_timezone_set('Africa/Lagos');
 $time_start = microtime(true);
 require_once('utils.php');
 require_once "initServer.php";
 require_once "mail/Swift_mail/lib/swift_required.php";
 require_once 'Spreadsheet/Classes/PHPExcel.php';
 $utils = new utils();
 $start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');
 $rpt_section = isset($_REQUEST['section'])?$_REQUEST['section']:'Tobacco'; 
 $logo = ($rpt_section == 'Tobacco')?'intermarket.jpg':'badistribution.png';
 set_time_limit(0); 
 /*error_reporting(E_ALL);
 ini_set('display_errors', TRUE);
 ini_set('display_startup_errors', TRUE); 
 ini_set('memory_limit', '1024M');*/ 
 function layoutSheet($excel,$sheetName,$caption){    
   global $logo;
   $sheetIndex = ($excel->getSheetCount()==1)?0:$excel->getSheetCount()-1;
   $excel->createSheet();   
   $excel->setActiveSheetIndex($sheetIndex);   
   $sheet = $excel->getActiveSheet();      
   if($sheet){
   $sheet->setTitle($sheetName);  
    
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Company logo');
    $objDrawing->setDescription('Company logo');
    $objDrawing->setPath(HMP."/design/$logo");
    $objDrawing->setHeight(72);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setOffsetX(10);
    $objDrawing->setWorksheet($sheet);
    
    
    $sheet->setCellValue('D2',$caption);
    $sheet->getStyle('D2')->getFont()->setName('Calibri');
    $sheet->getStyle('D2')->getFont()->setSize(20);
    $sheet->getStyle('D2')->getFont()->setBold(true);  
    $sheet->setCellValue('D3','Report Date: '.date('d/m/Y'));
    $sheet->getStyle('D3')->getFont()->setName('Calibri');
    $sheet->getStyle('D3')->getFont()->setSize(12);
    $sheet->getStyle('D3')->getFont()->setItalic(true);        
    return $sheet;
   }else{
    return false;
   }   
 }
 
 function getRecipients($doc_id){
   global $utils;
   $qry = "CALL load_mail_recipients(?)";
   $stmt = $utils->db->con->prepare($qry);
   $stmt->bind_param('i',$doc_id);
   $stmt->execute();
   $stmt->bind_result($title,$fullname,$email,$us_id);
   
   $ret = array();
   $a = 0;
    while($stmt->fetch() != NULL){
      $ret[$a] = array($title,$fullname,$email,$us_id);
      $a++;
    }        
   $stmt->close();
   return $ret;
 }
 
 function sendMail($user_id,$title,$recipient,$file_name){                  
        //reset encoding if required
        /*if(function_exists('mb_internal_encoding') && ((int) ini_get('mbstring.func_overload')) & 2){
         $mbEncoding = mb_internal_encoding();
         mb_internal_encoding('ASCII');
         echo "Internal encoding is: $mbEncoding, NOT ASCII";
        }*/
        
        global $utils;
        global $rpt_section;                
        $qry = "CALL load_user_mail_details(?,@owner,@depot)"; 
        $stmt = $utils->db->con->prepare($qry);        
        $stmt->bind_param('i',$user_id);
        $stmt->execute(); 
        $stmt->close();                         
        
        $qry = "SELECT @owner AS owner, @depot AS depot";
        $stmt = $utils->db->con->prepare($qry); 
        $stmt->execute();
        $stmt->bind_result($owner,$depot);
        $stmt->fetch();
        $stmt->close();                                                                    

        $conf = initServer::getConf();
        $host = $conf['mail']['host'];
        $port = $conf['mail']['port'];
        $user = $conf['mail']['defaultUser'];
        $usnm = $conf['site']['name'];
        $pwd = $conf['mail']['passwd'];  
        $site_url = $conf['site paths']['siteurl'];      
        $cc = array('adenowun.oladipupo@greatbrandsng.com');        
        
        $transport = Swift_SmtpTransport::newInstance($host, $port);
        $transport->setUsername($user);
        $transport->setPassword($pwd);
        
        $mailer = Swift_Mailer::newInstance($transport); 
        $logger = new Swift_Plugins_Loggers_ArrayLogger();
        $mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));               
        
        $subject = "$rpt_section - $depot - $title - $owner";        
        $msg = Swift_Message::newInstance();
        $msg->setSubject($subject);
        $msg->setFrom(array($user=>$usnm));
        $msg->setContentType("text/html");        
        $msg->attach(Swift_Attachment::fromPath('./exports/'.$file_name,'application/vnd.ms-excel'));                                          
         
        $msg->setTo($recipient);
        $msg->setCc($cc);   
        //$msg->setReadReceiptTo($cc);      
        $message = "
                      <p>Dear $owner,</p>
                       <br />
                       <p>Please find attached the <b>$title</b> for today.</p>
                       <br />
                       <p>Regards,</p>
                       <br />
                       <br />
                       <p><b>Mobile Trader</b></p>
                    ";
        $msg->setBody($message); 
        if($mailer->send($msg,$failures)){return true;}
        else{print_r($failures);$logger->dump();return false;}
        
        //revert encoding to previous
        /*if (isset($mbEncoding)){
        echo "Reverting internal encoding to: $mbEncoding";
         mb_internal_encoding($mbEncoding);*/
        
        
 }                  
   
   //headers
  $totalFormat = array(
			'font'    => array(
				'bold'      => true
			),
			'numberformat'    => array(
				'code'      => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
			),
			'borders' => array(
				'top'     => array(
 					'style' => PHPExcel_Style_Border::BORDER_THIN
 				)
			),
			'fill' => array(
	 			'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
	  			'rotation'   => 90,
	 			'startcolor' => array(
	 				'argb' => 'FFA0A0A0'
	 			),
	 			'endcolor'   => array(
	 				'argb' => 'FFFFFFFF'
	 			)
	 		)
		); 
   
  $cellOutline = array(
	'numberformat'    => array(
				'code'      => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
			),
  'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	  ),
   );
   
   $normFormat = array(	
  'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	  ),
   );
 
 $doc_id = 15; 
 $recipients = getRecipients($doc_id); 
 $totRecip = 1;//count($recipients); 
 
 for($z=0;$z<$totRecip;$z++){    
 set_time_limit(0);   
   $user_id = $recipients[$z][3];
   $email = $recipients[$z][2];
   $full_name = $recipients[$z][1];
   $report_title = $recipients[$z][0]; 
  $caption = "$report_title";

  $xlsFile = $rpt_section."_$report_title"."_$start_dtt.xls";
        $reportTitle = str_replace('.xls','',$xlsFile);
        $data_path = HMP."/exports/$xlsFile";
        @unlink($data_path);
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator("Mobiletrader")->setLastModifiedBy("Mobiletrader")
							 ->setTitle($reportTitle)
							 ->setSubject($reportTitle)
							 ->setDescription($reportTitle)
							 ->setKeywords("Executive Sales Summary")
							 ->setCategory("Sales Report");        
        
        $excel->setActiveSheetIndex(0);                
        
    $agent_ids = array(3317,3318);
    $agent_lbl = 'agent';
    for($u=0;$u<count($agent_ids);$u++){
    $gi = $u+1;
      $mainSheet = layoutSheet($excel,$agent_lbl."$gi",$caption); 
        if(!$mainSheet){
         continue;
        }
        
   $start_row = 5;
   $col = 1;
   $headers = array('SN','Channel','Region','Customer Code','Customer Name','Outlet Name','Address','Phone No.','Rep Name','Depot','Hope your order was fully supplied?','Does our rep visit this outlet?','Do you have stock left in your store?','How many to be precise?','Have you been informed of your rebates/rewards?','Hope you have been informed of our current prices, promo, discounts?','Why havent you bought for quite some time?','Are you ok with our services and brands?','if bad or poor, why?','Agent Name','call time','Call Duration','Date');  
   
    
   foreach($headers as $k => $v){
    $theCell = $utils->numToAlpha($col).$start_row;
    $mainSheet->setCellValue($theCell,$v);
    $mainSheet->getStyle($theCell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $mainSheet->getStyle($theCell)->getFill()->getStartColor()->setARGB('FF808080');
    $mainSheet->getStyle($theCell)->getFont()->setSize(12);
    $mainSheet->getStyle($theCell)->getFont()->setBold(true);
    $mainSheet->getStyle($theCell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    $mainSheet->getStyle($theCell)->getAlignment()->setWrapText(true);
    $mainSheet->getStyle($theCell)->applyFromArray($cellOutline);    
    $mainSheet->getColumnDimension($utils->numToAlpha($col))->setWidth(10);
    $mainSheet->getColumnDimension('I')->setAutoSize(true);    
    $col++;
   }
      
      $theAgent = $agent_ids[$u];  
      $qry = "CALL load_wrigly_call(?,?,?)";
      $stmt = $utils->db->con->prepare($qry);            
      $stmt->bind_param('iss',$theAgent,$start_dtt,$end_dtt);
      $stmt->execute();    
      $stmt->bind_result($id,$channel,$region,$customerno,$contactname,$outletname,$outletaddress,$contactphone,$repname,$depot,
		$stock_supplied,$rep_visitation,$stock_left,$stock_left_qty,$know_about_rewards,$know_about_discounts_prices,
		$why_you_havent_bought,$okay_with_services,$why_are_you_not_ok,$agentname,$calltime,$call_duration,$rdate);      
       $sn = 0;  
       $giz = 0;   
       $entry_dtt = date('d/m/Y');  
       while($stmt->fetch()){           
       $sn++;          
       
        $headers = array(   'SN','Channel','Region',
   'Customer Code',
   'Customer Name',
   'Outlet Name',
   'Address',
   'Phone No.',
   'Rep Name',
   'Depot',
   'Hope your order was fully supplied?',
   'Does our rep visit this outlet?',
   'Do you have stock left in your store?',
   'How many to be precise?',
   'Have you been informed of your rebates/rewards?',
   'Hope you have been informed of our current prices, promo, discounts?',
   'Why havent you bought for quite some time?', 
   'Are you ok with our services and brands?',
   'if bad or poor, why?',
   'Agent Name',
   'call time',
   'Call Duration',
   'Date');
        $giz += 1;
        $rowNum = $start_row+$giz;         
        $details = array($id,$channel,$region,$customerno,$contactname,$outletname,$outletaddress,$contactphone,$repname,$depot,
		$stock_supplied,$rep_visitation,$stock_left,$stock_left_qty,$know_about_rewards,$know_about_discounts_prices,
		$why_you_havent_bought,$okay_with_services,$why_are_you_not_ok,$agentname,$calltime,$call_duration,$rdate
                         );
         
         $cog = 1; 
        $normCols = array('B','C','D','E','F','G','H','I','J','K','L');                
        foreach($details as $k => $v){                 
         $theCell = $utils->numToAlpha($cog).$rowNum;
         $mainSheet->setCellValue($theCell,$v);
         $col_letter = $utils->numToAlpha($col);
         if(!in_array($utils->numToAlpha($cog),$normCols)){
         $mainSheet->getStyle($theCell)->applyFromArray($cellOutline);
         }else{
          $mainSheet->getStyle($theCell)->applyFromArray($normFormat);
          $mainSheet->getColumnDimension($col_letter)->setWidth(20);
          $mainSheet->getStyle($theCell)->getAlignment()->setWrapText(true);
         }                                    
         $cog++;
        }                
       }
       $stmt->close();   
       if($sn == 0){continue;} 
       
        $excel->setActiveSheetIndex(0);
        $excelWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
        $excelWriter->save($data_path);                
       
       }
       
       $tot = count($recipients);
        $tos = array();
        for($g=0;$g<$tot;$g++){
          $email = $recipients[$g][2];
          $full_name = $recipients[$g][1];
          $tos[$email] = $full_name;
        }
       
       if(sendMail($user_id,$report_title,$tos,$xlsFile)){echo "<p>sent to $tot recipients</p>";}
       else{echo "<p style='color:red;'>unable to send.</p>";}
       
}   

$time_end = microtime(true);
$script_duration = round($time_end - $time_start,1);
echo "script concluded in $script_duration seconds.<br/>";    
                   
?>