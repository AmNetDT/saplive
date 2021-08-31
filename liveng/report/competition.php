<?php

	require_once 'template.php';
	$start_dtt = $end_dtt = isset($_REQUEST['tran_date'])?$_REQUEST['tran_date']:date('Y-m-d');
	
	$qry = "
            SELECT  
				p.name AS 'Company',
				m.name AS 'UNIT',
				l.name AS 'REGION',
				o.name AS 'VEHICLE',
				CONCAT(e.first_name,' ',e.last_name) AS 'Rep Name',
				f.urno AS 'Customer No',
				q.name AS 'Outlet Class',
				f.outletname AS 'OUTLET NAME',
				f.outletaddress AS 'OUTLET ADRESS',
				f.contactPhone AS 'OUTLET PHONE',
				g.product_name AS 'SKU NAME',
				j.name AS 'DEPOT',
				k.name AS 'AREA',
				e.employee_code AS 'ED CODE',
				a.selling_price AS 'PRICE',
				a.avail AS 'AVAILABLE',
				b.date_idx AS 'Date'
				FROM 
				sales_route_visit_product a, 
				sales_route_visit b, 
				sales_route_plan c, 
				employee_outlet d, 
				employees e, 
				outlets f, 
				products g,
				employee_division h, 
				divisions_map i, 
				depots j, 
				areas k, 
				regions l, 
				divisions m, 
				employee_vehicle n, 
				vehicles o, 
				companies p, 
				outlet_class q
				WHERE a.sales_route_visit_id = b.id 
					AND b.sales_route_plan_id = c.id
					AND c.employee_outlet_id = d.id
					AND d.employee_id = e.id
					AND d.outlet_id = f.id
					AND a.product_id = g.id
					AND e.id = h.employee_id
					AND h.division_map_id = i.id
					AND i.depot_id = j.id
					AND i.area_id = k.id
					AND i.region_id = l.id
					AND i.division_id = m.id
					AND e.id = n.employee_id
					AND n.vehicles_id = o.id
					AND m.company_id = p.id
					AND f.outletClassId = q.id
					AND d.end_date LIKE '0000-00-00 00:00:00'
					AND h.end_date LIKE '0000-00-00 00:00:00'
					AND n.end_date LIKE '0000-00-00 00:00:00'
					AND b.date_idx >= '$start_dtt'
					AND b.date_idx <='$start_dtt'
					AND a.selling_price != 0.00
					LIMIT 99999999
        ";

	$conn = connect('mobiletrader');
	$recipient=2;
	$message = "
                       <p>Dear All,</p><p></p><br><br>
						Please,  find attached the <b>$unit</b> for all unit today.</p><br><br>
						<p>Regards,</p><br><br>
						<p><b>Mobile Trader</b></p>";
                     
    $headers = array("Company","UNIT","REGION","VEHICLE","Rep Name","Customer No","Outlet Class","OUTLET NAME","OUTLET ADDRRESS",
						"OUTLET PHONE","SKU NAME","DEPOT","AREA","ED CODE","PRICE","AVAILABLE","Date");
	$time_start = microtime(true);
	$file_name = "Competition_all_Report$start_dtt.xls";
    if(prepareExcel($file_name, $qry, $headers, 'Competiiton', 'Competition')){
		sendMail2($file_name, 'Competition', $message, $recipient);
	}else echo 'No details to send';
	$time_end = microtime(true); 
	$script_duration = round($time_end - $time_start,1); 
	echo "script concluded in $script_duration seconds.<br/>"; 
?>