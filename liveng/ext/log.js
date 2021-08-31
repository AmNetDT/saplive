//pull result of search.......
$(document).ready(function(){

	$('#logB').click(function(e) {
		e.preventDefault();
		$("#loaders").show();
		$.ajax({
		type: "POST",
		url: "sduser2.php",
		dataType: "json",
		data: $('#formUserAuth').serialize(),
		success: function(xhtR){
			 if(parseInt(xhtR.status)===400){
				$(".err_status").show().html(xhtR.responce);
			 }else if(parseInt(xhtR.status)===200){
				window.location=xhtR.url;
			 }
		  $("#loaders").hide();
		 }
		});
		return false;
	  });

	 $("#rxqq_pulls").change(function(e) {
	   var btnRegion = $("#rxqq_pulls").val();
	   var btn_widget_fd = $("#cont_widget_fd").val();
	   var region_id_keys = $(".region_id_keys").val();
	   var depots_id_keys = $(".depots_id_keys").val();
	   var syscate_id_keys = $(".syscate_id_keys").val();
	   getMtLiveProcessData(btnRegion, btn_widget_fd, region_id_keys, depots_id_keys, syscate_id_keys)
	 })


	 $('.cont_widget').change(function(e){

		var cont = parseInt($(this).val());
	  if(cont==1){

		$('.sales_modules_keys').show();
		$('.tm_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		//header
		$('.sales_rep_module').show();
		$('.tms_module').hide();
		$('.auditor_module').hide();
		$('.compitation_module').hide();
		//span
		$('.sales_sales_rep').show();
		$('.sales_tm').hide();
		$('.field_auditor').hide();
		$('.compitations_auditor').hide();

	  }else if(cont==2){
		$('.sales_modules_keys').hide();
		$('.tm_modules_keys').show();
		$('.auditor_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		//header
		$('.sales_rep_module').hide();
		$('.tms_module').show();
		$('.auditor_module').hide();
		$('.compitation_module').hide();
		//span
		$('.sales_sales_rep').hide();
		$('.sales_tm').show();
		$('.field_auditor').hide();
		$('.compitations_auditor').hide();
	  }else if(cont==3){
		$('.sales_modules_keys').hide();
		$('.tm_modules_keys').hide();
		$('.auditor_modules_keys').show();
		$('.auditor_modules_keys').hide();
		//header
		$('.sales_rep_module').hide();
		$('.tms_module').hide();
		$('.auditor_module').show();
		$('.compitation_module').hide();
		//span
		$('.sales_sales_rep').hide();
		$('.sales_tm').hide();
		$('.field_auditor').show();
		$('.compitations_auditor').hide();
	  }else if(cont==4){
		$('.sales_modules_keys').hide();
		$('.tm_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		$('.auditor_modules_keys').show();
		//header
		$('.sales_rep_module').hide();
		$('.tms_module').hide();
		$('.auditor_module').hide();
		$('.compitation_module').show();
		//span
		$('.sales_sales_rep').hide();
		$('.sales_tm').hide();
		$('.field_auditor').hide();
		$('.compitation_modules_keys').show();
	  }else{
		 //content
			$('.sales_modules_keys').hide();
		$('.tm_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		$('.auditor_modules_keys').hide();
		//header
		$('.sales_rep_module').hide();
		$('.tms_module').hide();
		$('.auditor_module').hide();
		$('.compitation_module').hide();
		//span
		$('.sales_sales_rep').hide();
		$('.sales_tm').hide();
		$('.field_auditor').hide();
		$('.compitations_auditor').hide();
	  }

	 })

	 //Application view scroll
		 $(".cen_c_c").on("scroll",function(){
			 var docViewTop = $(this).scrollTop();
			//$("#scrolls").html(docViewTop);
			 var f = $("#cont_widget_fd").val(); //field
			 if(parseInt(docViewTop) > 50){
				 if(parseInt(f)==1){
				   $("#scrolls").show();
				 }else if(parseInt(f)==2){
				   $("#scrolls_tms").show();
				 }else if(parseInt(f)==3){
				   $("#scrolls_audits").show();
				 }else if(parseInt(f)==4){
				   $("#scrolls_competition").show();
				 }

			 }else{
				 if(parseInt(f)==1){
				   $("#scrolls").hide();
				 }else if(parseInt(f)==2){
				   $("#scrolls_tms").hide();
				 }else if(parseInt(f)==3){
				   $("#scrolls_audits").hide();
				 }else if(parseInt(f)==4){
				   $("#scrolls_competition").hide();
				 }

			 }
		 })

	})

	setInterval(function(){
	  var btnRegion = $("#rxqq_pulls").val();
	  var btn_widget_fd = $("#cont_widget_fd").val();
	  var region_id_keys = $(".region_id_keys").val();
	  var depots_id_keys = $(".depots_id_keys").val();
	  var syscate_id_keys = $(".syscate_id_keys").val();
	  getMtLiveProcessData(btnRegion, btn_widget_fd, region_id_keys, depots_id_keys, syscate_id_keys)
	}, 3*60*1000);



	function getMtLiveProcessData(btnRegion,btn_widget_fd, region_id_keys, depots_id_keys, syscate_id_keys) {

	  $("#loaders").show();

	   const res = {
		'regionid': btnRegion,
		'depotid':depots_id_keys,
		'syscategoryid':syscate_id_keys,
		'employeeid':0
	   }

	   $.ajax({
		   type: "POST",
		   url: "http://www.mtnodejsapi.com:9000/api/automtlivefetch",
		   data: JSON.stringify(res),
		   contentType: 'application/json',
		   dataType: 'json',
		   success: function(datas) {

			 $("#load_active_sales_rep").show().html(datas.activerep);
			 $("#metric_clock_in").show().html(datas.notresume);
			 $("#metric_clock_out").show().html(datas.notclockout);
			 $('#newTable > tbody:last').empty()
			 $('#newTable > tbody:last').html()
			 $(".load_live_data").show()

			 let allData = datas.data
			 let totalPlannedOutlet = 0;
			 let totalActualClose = 0;
			 let totalActualOpen = 0;

			 for(let i = 0; i < allData.length; i++) {

			   totalPlannedOutlet += parseInt(datas.data[i].planned_outlet);
			   totalActualClose += parseInt(datas.data[i].actualclose);
			   totalActualOpen += parseInt(datas.data[i].actualopen);

			   $('#newTable > tbody:last').append(
				 `
				 <tr>
				   <td valign="top"><div style="width:30px;">${i+1}</div></td>
				   <td valign="top"><div style="width:80px;">${datas.data[i].channel}</div></td>
				   <td valign="top"><div style="width:120px;">${datas.data[i].repname}</div></td>
				   <td valign="top"><div style="width:100px;">${datas.data[i].depots}</div></td>
				   <td valign="top"  style="text-align:center"><div style="width:70px;">
					  ${
						 (() => {
							 if(datas.data[i].resume == "00:00:00") {
								 return `<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>`;

							 } else {
								 return `<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>`;

							 }
						 })()
					  }
					  <div style="font-size:9px; font-weight:bold">${datas.data[i].resume}</div>
				   </div></td>

				   <td valign="top"  style="text-align:center"><div style="width:70px;">
					  ${
						 (() => {
							 if(datas.data[i].clockout == "00:00:00") {
								 return `<li class="fa fa-circle text-red" style="margin:0px;padding:0px;"> </li>`;

							 } else {
								 return `<li class="fa fa-circle text-green" style="margin:0px;padding:0px;"> </li>`;

							 }
						 })()
					  }
					  <div style="font-size:9px; font-weight:bold">${datas.data[i].clockout}</div>
				   </div></td>

				   <td valign="top" style="text-align:center"><div style="width:80px;">${datas.data[i].planned_outlet}</div></td>

				   <td valign="top" style="font-size:13px; text-align:center"><div style="width:60px;">
				   ${
					  (() => {
						return datas.data[i].actualclose+datas.data[i].actualopen
					   })()
					}
					</div></td>

					<td valign="top" style="font-size:13px; text-align:center"><div style="width:60px;">
					${
					   (() => {
						 return datas.data[i].actualopen
						})()
					 }
					 </div></td>

					 <td valign="top" style="font-size:13px; text-align:center"><div style="width:60px;">
					 ${
						(() => {
						  return datas.data[i].actualclose
						 })()
					  }
					  </div></td>

					  <td valign="top" style="font-size:13px; text-align:center"><div style="width:60px;">


					  ${
					 (() => {

						 const results = (((datas.data[i].actualclose+datas.data[i].actualopen) / datas.data[i].planned_outlet)*100).toFixed(0);
						 const resul = (((datas.data[i].actualclose+datas.data[i].actualopen) / datas.data[i].planned_outlet)*100).toFixed(1);

						 if(results >= 0 && results <= 50){
						   return `
						   <div style="text-align:center;margin:0px;padding:0px;"><b>${resul}%</b></div>
						   <div class="progress progress-xs progress-striped active">
						   <div class="progress-bar progress-bar-danger" style="width:${results}%"></div>
						   </div>
						   `
						 }else if(results >= 51 && results <= 70){
							return `
							<div style="text-align:center;margin:0px;padding:0px;"><b>${resul}%</b></div>
							<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-warning" style="width:${results}%"></div>
							</div>
							`
						 }else if(results >= 71 && results <= 95){
							return `
							<div style="text-align:center;margin:0px;padding:0px;"><b>${resul}%</b></div>
							<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-primary" style="width:${results}%"></div>
							</div>
							`
						 }else if(results >= 96 && results <= 100){
							return `
							<div style="text-align:center;margin:0px;padding:0px;"><b>${resul}%</b></div>
							<div class="progress progress-xs progress-striped active">
							<div class="progress-bar progress-bar-success" style="width:${results}%"></div>
							</div>
							`
						 }else{
						   return `
						   <div style="text-align:center;margin:0px;padding:0px;"><b>0%</b></div>
							 <div style="width:50px;">
							 <div class="progress progress-xs progress-striped active">
							 <div class="progress-bar progress-bar-danger" style="width:0%"></div>
							 </div>
						   `
						 }
					 })()
				  }

					  </div></td>


				</tr>
				 `
			   );
			 }

			 let percetageCovered = (((totalActualClose+totalActualOpen)/totalPlannedOutlet)*100).toFixed(1)
			 $("#metric_percent_covered").show().html(percetageCovered);

       let percetageOpen = (((totalActualOpen)/totalPlannedOutlet)*100).toFixed(1)
			 $("#metric_percent_open").show().html(percetageOpen);

       let percetageClose = (((totalActualClose)/totalPlannedOutlet)*100).toFixed(1)
			 $("#metric_percent_close").show().html(percetageClose);

			 $("#loaders").hide();
		   }
		 })
	}
