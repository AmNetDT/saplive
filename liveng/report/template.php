<?php
    require_once 'Spreadsheet/Classes/PHPExcel.php';
    require 'SendMail.php';
	
	
	$totalFormat=null;
	$cellOutline=null;
	$normFormat=null;
	function layoutSheet($excel,$sheetName,$caption){ 
		$sheetIndex = ($excel->getSheetCount()==1)?0:$excel->getSheetCount()-1; 
		$excel->createSheet(); 
		$excel->setActiveSheetIndex($sheetIndex); 
		$sheet = $excel->getActiveSheet(); 
		if($sheet){ 
			$sheet->setTitle($sheetName); 
			$sheet->setCellValue('D2',$caption); 
			$sheet->getStyle('D2')->getFont()->setName('Calibri'); 
			$sheet->getStyle('D2')->getFont()->setSize(20); 
			$sheet->getStyle('D2')->getFont()->setBold(true); 
			$sheet->setCellValue('D3',''.date('d/m/Y')); 
			$sheet->getStyle('D3')->getFont()->setName('Calibri'); 
			$sheet->getStyle('D3')->getFont()->setSize(12); 
			$sheet->getStyle('D3')->getFont()->setItalic(true); 
			return $sheet; 
		}else{ 
			return false; 
		} 
	}
	
	function initialized(){
		global $totalFormat;
		global $cellOutline;
		global $normFormat;
		//headers 
		$totalFormat = array( 
			'font' => array( 
				'bold' => true 
			), 
			'numberformat' => array( 	
				'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 
			), 
			'alignment' => array( 
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, 
			), 
			'borders' => array( 
				'top' => array( 
					'style' => PHPExcel_Style_Border::BORDER_THIN 
				) 
			), 
			'fill' => array( 
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR, 
				'rotation' => 90, 
				'startcolor' => array( 
					'argb' => 'FFA0A0A0' 
					), 
				'endcolor' => array( 	
					'argb' => 'FFFFFFFF' 
				) 
			) 
		); 

		$cellOutline = array( 
			'numberformat' => array( 
				'code' => PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1 
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
				'color' => array(
					'argb' => 'FF000000'), 
				), 
			), 
		); 

	}

	function start(){
		initialized();
		date_default_timezone_set('Africa/Lagos'); 
		$time_start = microtime(true); 
		//$utils = new utils(); 
		$start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');//'2017-12-22'
		$rpt_section = isset($_REQUEST['section'])?$_REQUEST['section']:'Tobacco'; 
		$logo = ($rpt_section == 'Tobacco')?'intermarket.jpg':'badistribution.png'; 
		$report_type = isset($_REQUEST['report_type'])?$_REQUEST['report_type']:'mail'; 
		$myId = $utils->ses->getUserId(); 
		set_time_limit(0); 
		error_reporting(E_ALL); 
		ini_set('display_errors', TRUE); 
		ini_set('display_startup_errors', TRUE); 
		ini_set('memory_limit', '1024M');
	}
	
	function prepareExcel($data_path, $qry, $headers, $name, $title){ 
        global $start_dtt, $conn;
        $reportTitle = 'My Report';
		set_time_limit(0); 
		$excel = new PHPExcel(); 
		$excel->getProperties()->setCreator("Mobiletrader")->setLastModifiedBy("Mobiletrader") 
			->setTitle($name) 
			->setSubject($name) 
			->setDescription($name) 
			->setKeywords("Reports") 
			->setCategory("Calls Report"); 
		$excel->setActiveSheetIndex(0);
	
		$mainSheet = layoutSheet($excel,$title,$title); 
		if(!$mainSheet){ 
			continue; 
		} 
        setColumn($mainSheet, $headers);
		$start_row = 6; 
        $stmt = $conn->query($qry); 	
		$sn = 0; 
		$giz = 0; 
		list($sd_yr,$sd_mo,$sd_da) = explode('-',$start_dtt); 
        $entry_dtt = date("$sd_da/$sd_mo/$sd_yr"); 
        $j = count($headers);
		while($result = $stmt->fetch_row()){
			$details = array();
			$i=0;
			while($i<$j){
				$details[] = $result[$i];
				$i++;
			}
            insertToRow($mainSheet, $details, $sn+$start_row);
			$sn++;
		}
		if($sn >0){
			$excelWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
			$excelWriter->save($data_path);
		}
		
		return $sn!=0;
	
	} 

	function insertToRow($mainSheet, $details, $rowNum){
        global $cellOutline;
		$cog = 0; 
		$normCols = array('G','H','J'); 
		foreach($details as $k => $v){ 
			$theCell = numToAlpha($cog).$rowNum; 
			$mainSheet->setCellValue($theCell,$v); 
			if(!in_array(numToAlpha($cog),$normCols)){ 
				//$mainSheet->getStyle($theCell)->applyFromArray($cellOutline); 
			}else{ 
				//$mainSheet->getStyle($theCell)->applyFromArray($normFormat); 
			} 
			$mainSheet->getColumnDimension('J')->setAutoSize(true); 
			$cog++; 
		} 
    }
    
    function numToAlpha($col){
        $alpha= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		$first = ($col/26)-1;
		if($first>=0)return $alpha[$first].$alpha[$col%26];
		else return $alpha[$col%26];
    }
	
	function setColumn($mainSheet, $headers){
        global $cellOutline;
        $start_row=5;
		$col = 0;
		foreach($headers as $k => $v){ 
            $theCell = numToAlpha($col).$start_row;
            $mainSheet->setCellValue($theCell,$v); 
			$mainSheet->getStyle($theCell)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID); 
			$mainSheet->getStyle($theCell)->getFill()->getStartColor()->setARGB('FF808080'); 
			$mainSheet->getStyle($theCell)->getFont()->setSize(12); 
			$mainSheet->getStyle($theCell)->getFont()->setBold(true); 
			$mainSheet->getStyle($theCell)->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE); 
			$mainSheet->getStyle($theCell)->getAlignment()->setWrapText(true); 
			//$mainSheet->getStyle($theCell)->applyFromArray($cellOutline); 
			$mainSheet->getColumnDimension(numToAlpha($col))->setWidth(10); 
			$mainSheet->getColumnDimension('I')->setAutoSize(true); 
			$col++; 
		} 
	}
?>