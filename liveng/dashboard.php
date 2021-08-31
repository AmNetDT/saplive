<?php session_start(); ?>
<?php

require_once 'sql/users.php';
require_once 'dbconfig/db.php';

$db = new db();
$conn = $db->connect();


if (!isset($_SESSION['NTY3ODk3NDM0NTY3O876543235Dkw'])) {
  print "<script>";
  print "window.location.href='index.php'";
  print "</script>";
}

$users_id = $_SESSION['NTY3ODk3NDM0NTY3O876543235Dkw'];
$sys = $conn->prepare(DbQuery::userDetails());
$sys->execute(array($users_id));
$syscat = $sys->fetch();
$region_id = $syscat['region_id'];
$depots_id = $syscat['depots_id'];
$syscate_id = $syscat['syscategory_id'];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Live::Sales::Data</title>
  <link rel="stylesheet" type="text/css" href="client_library/cen.lib-3.1.2.css" />
  <link rel="stylesheet" type="text/css" href="client_library/centracle.css" />
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="client_library/table.min.css" />
  <link rel="stylesheet" type="text/css" href="font-awesome/css/centt.min.css" />
  <link rel="stylesheet" type="text/css" href="font-awesome/css/centtt.css" />


  <script type="text/javascript" src="client_library/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="client_library/socket.io.js"></script>
  <script type="text/javascript" src="client_library/cen_lib.js"></script>
  <script type="text/javascript" src="client_library/modernizr.js"></script>
  <script type="text/javascript" src="client_library/pageloader.js"></script>
  <script type="text/javascript" src="client_library/app.min.js"></script>
  <link rel="stylesheet" type="text/css" href="client_library/pop.css" />
  <script type="text/javascript" src="client_library/pops.js"></script>
  <link rel="stylesheet" type="text/css" href="client_library/pop.css" />
  <script src="ext/log.js"></script>
  <script type="text/javascript" src="client_library/socket.io.js"></script>



  <script>
    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
      var t = setTimeout(startTime, 500);
    }

    function checkTime(i) {
      if (i < 10) {
        i = "0" + i
      }; // add zero in front of numbers < 10
      return i;
    }
  </script>
  <style>
    li.fs_st {
      color: #000;
      cursor: pointer;
      padding: 3px;
    }

    li.fs_clos {
      color: #fff;
      cursor: pointer;
      padding: 3px;
    }

    li.fs_st:hover,
    li.fs_clos:hover {
      color: #F5F5F5;
    }

    .navbar-nav>li>a {
      color: #FFF;
    }


    #loaders {
      display: none;
    }


    .sales_modules_keys,
    .tm_modules_keys,
    .auditor_modules_keys,
    .sales_tm,
    .sales_sales_rep,
    .field_auditor,
    .compitations_auditor,
    .compitation_modules_keys {
      display: none;
    }
  </style>
</head>


<body onload="startTime()">


  <div class="box-header cen_r_h" style="padding:0px">
    <img src="logs.fw.png" width="81" height="37" class="pull-left" style="margin-left:1%; margin-top:6px;" />
    <div class="box-tools pull-right">
      <ul class="list-inline">
        <li> <a href="#"><span id="txt"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="metric_server_date"></span></a></li>
      </ul>
    </div>


    <div style="margin:auto; width:1100px;margin-bottom:20px;">
      <!--sales rep start here -->
      <div class="box-header sales_modules_keys">

        <i class="fa fa-area-chart" aria-hidden="true"></i>
        <h3 class="box-title" style=" margin-right:20px">Active Reps: <b><span id="load_active_sales_rep">0</span></b></h3>
        <i class="fa fa-align-left" aria-hidden="true"></i>
        <h3 class="box-title" style=" margin-right:20px">Not Resumed: <b><span id="metric_clock_in">0</span></b></h3>
        <i class="fa  fa-signal"></i>
        <h3 class="box-title" style=" margin-right:20px">Not Clocked Out: <b><span id="metric_clock_out">0</span></b></h3>
        <i class="fa  fa-line-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">% Covered: <b><span id="metric_percent_covered"></span>0</b></h3>


        <h3 class="box-title" style=" margin-right:20px">% Open: <b><span id="metric_percent_open"></span>0</b></h3>


        <h3 class="box-title" style=" margin-right:20px">% Close: <b><span id="metric_percent_close"></span>0</b></h3>
      </div>
      <!--sales rep end here -->

      <!--sales field auditor start here -->
      <div class="box-header auditor_modules_keys">
        <i class="fa  fa-align-center"></i>
        <h3 class="box-title" style=" margin-right:20px">No. of Active Reps: <b><span id="load_active_modules"></span></b></h3>
        <i class="fa fa-bar-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Resumed: <b><span id="metric_clock_in_modules"></span></b></h3>
        <i class="fa  fa-signal"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Clocked Out: <b><span id="metric_clock_out_modules"></span></b></h3>
        <i class="fa  fa-line-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">% Covered: <b><span id="metric_percent_covered_modules"></span></b></h3>
      </div>
      <!--sales field auditor end here -->


      <!--sales field tm start here -->
      <div class="box-header tm_modules_keys">
        <i class="fa  fa-align-center"></i>
        <h3 class="box-title" style=" margin-right:20px">No. of Active TM's: <b><span id="load_active_tm_modules"></span></b></h3>
        <i class="fa fa-bar-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Resumed: <b><span id="metric_clock_in_tm"></span></b></h3>
        <i class="fa  fa-signal"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Clocked Out: <b><span id="metric_clock_out_tm"></span></b></h3>
        <i class="fa  fa-line-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">Total Outlets Visited: <b><span id="metric_percent_covered_modules_tm"></span></b></h3>
      </div>
      <!--sales field tm end here -->


      <!-- compitation price start here -->
      <div class="box-header compitation_modules_keys">
        <i class="fa  fa-align-center"></i>
        <h3 class="box-title" style=" margin-right:20px">No. of Active TM's: <b><span id="load_active_tm_modules"></span></b></h3>
        <i class="fa fa-bar-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Resumed: <b><span id="metric_clock_in_tm"></span></b></h3>
        <i class="fa  fa-signal"></i>
        <h3 class="box-title" style=" margin-right:20px">No. Not Clocked Out: <b><span id="metric_clock_out_tm"></span></b></h3>
        <i class="fa  fa-line-chart"></i>
        <h3 class="box-title" style=" margin-right:20px">Total Outlets Visited: <b><span id="metric_percent_covered_modules_tm"></span></b></h3>
      </div>
      <!-- compitation price -->



    </div>

  </div>



  <div class=" box box-primary" style="width:98%;margin-left:1%; margin-bottom:0px;"></div>



  <div class="cen_c_c" style="margin-top:-30px">
    <div class="cen_c_qw">



      <section class="content">
        <div class="row">
          <!-- left column -->
          <div style="margin:auto; width:1200px;">
            <!-- general form elements -->
            <div class="box box-danger">
              <div class="box-header">
                <i class="fa fa-map-marker"></i>
                <h3 class="box-title">Auto Load
                  <span class="sales_tm">TM</span>
                  <span class="sales_sales_rep">SALES REP</span>
                  <span class="field_auditor">FIELD AUDITOR</span>
                  <span class="compitations_auditor">PRICING</span>
                </h3>




                <div class="box-tools pull-right">
                  <img src="rot_small.gif" id="loaders" width="18" height="18" style="">
                  <span><a href="sduser2.php?b_act=logout" id="logout">Log Out</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
                  <select class="cont_widget" id="cont_widget_fd">
                    <option value="0" selected="selected">Select Field</option>
                    <option value="1">Sales Reps</option>
                  </select>

                  <select id="rxx">
                    <option value="1">Company</option>
                  </select>

                  <select id="rxqq_pulls">
                    <option value="0" selected="selected">Select Region</option>
                    <?php
                    if ($syscate_id == 3 || $syscate_id == 4 || $syscate_id == 8) {
                      $stm = $conn->prepare(DbQuery::userRegionMonitor());
                      $stm->execute(array($region_id));
                    } else if ($syscate_id == 1 || $syscate_id == 7) {
                      $stm = $conn->prepare(DbQuery::userRegionAdmin());
                      $stm->execute();
                    }
                    while ($stmp = $stm->fetch()) {
                    ?>
                      <option value="<?php echo $stmp['id'] ?>"><?php echo $stmp['name'] ?></option>
                    <?php
                    }
                    ?>
                  </select>


                </div>

              </div>








              <!-- The sales rep Start here-->
              <div class="box-body rxr sales_rep_module" style="margin-top:-20px; display:none">


                <table class="table table-bordered" id="scrolls" style="font-size:11px; margin:0; padding:0px; position:fixed; width:1100px; margin-top:-50px; background:#FFF; display:none;">
                  <thead>
                    <tr style="margin:0px; padding:0px">
                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:120px;">Sales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:100px;">Depot Location</div>
                      </th>
                      <th>
                        <div style="width:70px;">Resumption Time</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:80px;">Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:60px;">Actual Visits</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Open Outlet</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Close Outlet</div>
                      </th>
                      <th style="text-align:center">
                        <div style="width:100px;">% Covered</div>
                      </th>
                      </th>
                    </tr>
                  </thead>
                </table>


                <table class="table table-bordered" style="font-size:11px; margin:0; padding:0px;width:1100px;" id="newTable">
                  <thead>
                    <tr style="margin:0px; padding:0px">
                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:120px;">Sales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:100px;">Depot Location</div>
                      </th>
                      <th>
                        <div style="width:70px;">Resumption Time</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:80px;">Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:60px;">Actual Visits</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Open Outlet</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Close Outlet</div>
                      </th>
                      <th style="text-align:center">
                        <div style="width:100px;">% Covered</div>
                      </th>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="load_live_data"></tbody>
                </table>
              </div>
              <!-- The sales rep end here-->




              <!-- The tm Start here-->
              <div class="box-body rxr tms_module" style="margin-top:-20px; display:none">


                <table class="table table-bordered" id="scrolls_tms" style="font-size:11px; margin:0; padding:0px; position:fixed; width:1100px; margin-top:-50px; background:#FFF; display:none;">
                  <thead>
                    <tr style="margin:0px; padding:0px">

                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">TM Name</div>
                      </th>
                      <th>
                        <div style="width:130px;">Rep on joint Call</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:100px;">Rep Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Resume</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:90px;">Visited Outlets</div>
                      </th>



                    </tr>
                  </thead>
                </table>


                <table class="table table-bordered" style="font-size:11px; margin:0; padding:0px;width:1100px;">
                  <thead>
                    <tr style="margin:0px; padding:0px">

                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">TM Names</div>
                      </th>
                      <th>
                        <div style="width:130px;">Rep on joint Call</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:100px;">Rep Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Resume</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:90px;">Visited Outlets</div>
                      </th>



                    </tr>
                  </thead>
                  <tbody class="load_live_data_tm"></tbody>
                </table>
              </div>
              <!-- The tm end here-->




              <!-- The auditor Start here-->
              <div class="box-body rxr auditor_module" style="margin-top:-20px; display:none">


                <table class="table table-bordered" id="scrolls_audits" style="font-size:11px; margin:0; padding:0px; position:fixed; width:1100px; margin-top:-50px; background:#FFF; display:none;">
                  <thead>
                    <tr style="margin:0px; padding:0px">

                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">BSales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:100px;">Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Resume</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:90px;">Visited Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:50px;">Unit Sold</div>
                      </th>
                      <th colspan="2" style="text-align:center">
                        <div style="width:120px;">% Covered</div>
                      </th>


                    </tr>
                  </thead>
                </table>


                <table class="table table-bordered" style="font-size:11px; margin:0; padding:0px;width:1100px;">
                  <thead>
                    <tr style="margin:0px; padding:0px">

                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">BSales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:100px;">Planned Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Resume</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:70px;">Clock Out</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:90px;">Visited Outlets</div>
                      </th>
                      <th style="text-align:center;">
                        <div style="width:50px;">Unit Sold</div>
                      </th>
                      <th colspan="2" style="text-align:center">
                        <div style="width:100px;">% Covered</div>
                      </th>
                      </th>


                    </tr>
                  </thead>
                  <tbody class="load_live_data_auditor"></tbody>
                </table>
              </div>
              <!-- The auditor end here-->



              <!-- The COMPITATION Start here-->
              <div class="box-body rxr compitation_module" style="margin-top:-20px; display:none">


                <table class="table table-bordered" id="scrolls_competition" style="font-size:11px; margin:0; padding:0px; position:fixed; width:1100px; margin-top:-50px; background:#FFF; display:none;">
                  <thead>
                    <tr style="margin:0px; padding:0px">
                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">Sales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th align="left">
                        <div style="width:600px;">

                          <table border="0" cellpadding="0" cellspacing="0" style="width:600px">
                            <tr>
                              <td>
                                <div style="width:250px">OUR SKU</div>
                              </td>
                              <td>
                                <div style="width:90px">COMPETITOR SKU</div>
                              </td>
                              <td>
                                <div style="width:90px">AVAILABLE</div>
                              </td>
                              <td>
                                <div style="width:90px">UOM<< /div>
                              </td>
                              <td>
                                <div style="width:50px">PRICE</div>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </th>
                    </tr>
                  </thead>
                </table>


                <table class="table table-bordered" style="font-size:11px; margin:0; padding:0px;width:1100px;">
                  <thead>
                    <tr style="margin:0px; padding:0px">
                      <th height="20">
                        <div style="width:30px;">Sn</div>
                      </th>
                      <th>
                        <div style="width:80px;">Channel</div>
                      </th>
                      <th>
                        <div style="width:90px;">Division</div>
                      </th>
                      <th>
                        <div style="width:130px;">Sales Rep. Name</div>
                      </th>
                      <th>
                        <div style="width:130px;">Depot Location</div>
                      </th>
                      <th align="left">
                        <div style="width:600px;">

                          <table border="0" cellpadding="0" cellspacing="0" style="width:600px">
                            <tr>
                              <td>
                                <div style="width:250px">OUR SKU</div>
                              </td>
                              <td>
                                <div style="width:90px">COMPETITOR SKU</div>
                              </td>
                              <td>
                                <div style="width:90px">AVAILABLE</div>
                              </td>
                              <td>
                                <div style="width:90px">UOM</div>
                              </td>
                              <td>
                                <div style="width:50px">PRICE</div>
                              </td>
                            </tr>
                          </table>


                        </div>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="load_live_data_competition">

                  </tbody>
                </table>
              </div>
              <!-- The COMPITATION Start here -->





            </div>
            <!-- /.box -->

            <!-- Form Element sizes -->
            <!-- /.box -->
            <!-- /.box -->

            <!-- Input addon -->
            <!-- /.box -->

          </div>


        </div>
        <!-- /.row -->
      </section>


    </div>

  </div>

  <input type="hidden" class="region_id_keys" value="<?php echo $region_id ?>" />
  <input type="hidden" class="depots_id_keys" value="<?php echo $depots_id ?>" />
  <input type="hidden" class="syscate_id_keys" value="<?php echo $syscate_id ?>" />
</body>

</html>