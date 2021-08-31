<?php 
class DbQuery{

    public static function liveDataLogin(){
		$init = " 
		select a.id, a.fullname as name, a.region_id, a.depot_id, system_category_id
        from users a
        where a.username = ?
		and a.password = ?";
		return $init; 
	}

    public static function userDetails(){
		$init = " 
		select  a.region_id, a.depot_id as depots_id, system_category_id as syscategory_id
        from users a 
        where a.id = ?";
		return $init; 
	}

	public static function userRegionAdmin() {
		$init = " 
		select id,name from region";
		return $init; 
	}

    public static function userRegionMonitor(){
		$init = " 
		select id,name from region where id =  ?";
		return $init; 
	}

	public static function repsLiveData(){
		$init = " 
		WITH Ranking (id, fullname, channel,depot,tclockin,tclokout,tplannedoutlet,visitoutlet,token)
		AS
		(
		SELECT  a.id, 
		CONCAT(a.first_name,' ',a.middle_name,' ',a.last_name) as fullname, 
		(select name from vehicles where id = a.vehicle_id limit 1) as channel,
		(select name from depots where id = a.depots_id limit 1) as depot,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  1 limit 1) as tclockin,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  2 limit 1) as tclokout,
		(select planned_outlet from daily_planned_outlets where employee_id  = a.id and entry_date = ?) as tplannedoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date = ? and token_verify <> 'orderconfirm') as visitoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date =  ? and token_verify <> '2211' and token_verify <> '0000' and token_verify <> 'orderconfirm') as token
		FROM users a where region_id =  ? and a.syscategory_id = 2 and a.activate = 'YES'
		order by tclockin asc, tclokout asc
		)
		SELECT id, fullname, channel,depot, tclockin as clockin,tclokout as clokout, 
		COALESCE(tplannedoutlet,0)  as plannedoutlet, visitoutlet,token, NULLIF(tplannedoutlet,0)::numeric/NULLIF(visitoutlet,0)::numeric as totals
		FROM Ranking 
		order by totals desc";
		return $init; 
	}

	public static function repsLiveDataSupervisor(){
		$init = " 
		WITH Ranking (id, fullname, channel,depot,tclockin,tclokout,tplannedoutlet,visitoutlet,token)
		AS
		(
		SELECT  a.id, 
		CONCAT(a.first_name,' ',a.middle_name,' ',a.last_name) as fullname, 
		(select name from vehicles where id = a.vehicle_id limit 1) as channel,
		(select name from depots where id = a.depots_id limit 1) as depot,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  1 limit 1) as tclockin,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  2 limit 1) as tclokout,
		(select planned_outlet from daily_planned_outlets where employee_id  = a.id and entry_date = ?) as tplannedoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date = ? and token_verify <> 'orderconfirm') as visitoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date =  ? and token_verify <> '2211' and token_verify <> '0000' and token_verify <> 'orderconfirm') as token
		FROM users a where region_id =  ? and depots_id = ? and a.syscategory_id = 2 and a.activate = 'YES'
		order by tclockin asc, tclokout asc
		)
		SELECT id, fullname, channel,depot, tclockin as clockin, tclokout as clokout, 
		COALESCE(tplannedoutlet,0)  as plannedoutlet, visitoutlet,token, NULLIF(tplannedoutlet,0)::numeric/NULLIF(visitoutlet,0)::numeric as totals
		FROM Ranking 
		order by totals desc";
		return $init; 
	}

	public static function repsLiveDataHo(){
		$init = " 
		WITH Ranking (id, fullname, channel,depot,tclockin,tclokout,tplannedoutlet,visitoutlet,token)
		AS
		(
		SELECT  a.id, 
		CONCAT(a.first_name,' ',a.middle_name,' ',a.last_name) as fullname, 
		(select name from vehicles where id = a.vehicle_id limit 1) as channel,
		(select name from depots where id = a.depots_id limit 1) as depot,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  1 limit 1) as tclockin,
		(select entry_time from employee_task where employee_id = a.id  and entry_date = ? and task_id =  2 limit 1) as tclokout,
		(select planned_outlet from daily_planned_outlets where employee_id  = a.id and entry_date = ?) as tplannedoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date = ? and token_verify <> 'orderconfirm') as visitoutlet,
		(select count(id) from employee_visited_outlet where employee_id = a.id and entry_date =  ? and token_verify <> '2211' and token_verify <> '0000' and token_verify <> 'orderconfirm') as token
		FROM users a where a.syscategory_id = 2 and a.activate = 'YES'
		order by tclockin asc, tclokout asc
		)
		SELECT id, fullname, channel,depot, tclockin as clockin,tclokout as clokout, 
		COALESCE(tplannedoutlet,0)  as plannedoutlet, visitoutlet,token, NULLIF(tplannedoutlet,0)::numeric/NULLIF(visitoutlet,0)::numeric as totals
		FROM Ranking 
		order by totals desc";
		return $init; 
	}

	public static function activeRepBySysMonitorAndAdmin(){
		$init = " 
		SELECT  count(a.id) as id
		FROM users a where region_id =  ? and a.syscategory_id = 2 and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysAdmin(){
		$init = " 
		SELECT  count(a.id) as id
		FROM users a where a.syscategory_id = 2 and a.activate = 'YES'";
		return $init;  
	}

	public static function activeRepBySysSupervisor(){
		$init = " 
		SELECT  count(a.id) as id
		FROM users a where region_id =  ? and depots_id = ? and a.syscategory_id = 2 and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysAdminClockIn(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 1
		and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysAdminAndRepClockIn(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 1
		and a.region_id = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysTMClockIn(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 1
		and a.region_id = ?
		and a.depots_id = ?
		and a.activate = 'YES'";
		return $init; 
	}


	public static function activeRepBySysAdminClockOut(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 2
		and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysAdminAndRepClockOut(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 2
		and a.region_id = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function activeRepBySysTMClockOut(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_task b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and task_id = 2
		and a.region_id = ?
		and a.depots_id = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function TmPlanedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, sales_route_plan b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.visit_date = ?
		and a.region_id = ?
		and a.depots_id = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function RepAndAdminPlanedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, sales_route_plan b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.visit_date = ?
		and a.region_id = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function AdminPlanedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, sales_route_plan b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.visit_date = ?
		and a.activate = 'YES'";
		return $init; 
	}

	public static function TmVisitedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_visited_outlet b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and a.region_id = ?
		and a.depots_id = ?
		and a.activate = 'YES'
		and b.token_verify <> 'orderconfirm'";
		return $init; 
	}

	public static function AdminVisitedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_visited_outlet b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and a.activate = 'YES'
		and b.token_verify <> 'orderconfirm'";
		return $init; 
	}

	public static function RepAndAdminVisitedOutlets(){
		$init = " 
		select count(a.id) as id 
		from users a, employee_visited_outlet b
		where a.syscategory_id = 2 
		and a.id = b.employee_id
		and b.entry_date = ?
		and a.region_id = ?
		and a.activate = 'YES'
		and b.token_verify <> 'orderconfirm'";
		return $init; 
	}

	

	

	


	
}
	
?>