<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Outlets Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/style.css">
</head>
<body>
    
    <div class="container">
        
        <div class="row">
            <div class="col-md-4">
                <h3>OUTLET TOOL</h3>
            </div>
            <div class="col-md-8">
                <div id="conn"><h5>Network: <span id="status"></span></h5></div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <b>Validate Employee</b><hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <p><input type="text" class="form-control" name="username" id="username" placeholder="Enter User Password (E.g. E0345934)" />
                </p>
            </div>
            <div class="col-md-5">
                <input type="number" class="form-control" name="pin" id="pin" placeholder="Enter User Pin (E.g. 1234)" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <button id="btnFirst" class="btn btn-md btn-info">Get Employee Details</button>
                <img id="loader1" class="loader" src="loader.gif" alt="loader" width="30" />
            </div>
        </div>
        <hr>
        <div class="row" id="results1">
            <div class="col-md-3">
                <div id="first-result"></div>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-12">
                <b>Create New Outlets</b><hr />
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <form>
                    <p><input type="number" class="form-control" name="empidcreate" id="empidcreate" placeholder="Enter Employee ID" /></p>
                    <p><input type="number" class="form-control" name="no" id="no" placeholder="Number Of Outlets To Create" /></p>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <button id="btnThird" class="btn btn-md btn-success">Create Outlets</button>
                <img id="loader3" class="loader" src="loader.gif" alt="loader" width="30" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr />
                <div>
                    <div id="third-result"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script>

        $(document).ready(function(){
            
            $(".loader").hide();

            function conn() {
                $.ajax({
                    url: 'includes/checkInternet.inc.php',
                    type: 'GET',
                    success: function(xhtR) {
                        $('#status').fadeIn('slow','linear',function(){
                            $(this).html(xhtR);
                        });
                    },
                    error: function(){
                        $('#status').fadeIn('slow','linear',function(){
                            $(this).html("An error occurred. Try again!");
                        });
                    }
                
                });
            }
            setInterval(conn, 5000);

            $('#btnFirst').click(function(){
                var pin = $('#pin').val();
                var username = $('#username').val(); 
                $("#loader1").show();
                $.ajax({
                    url: 'api/employeeDetails?pin='+pin+'&username='+username,
                    type: 'POST',
                    success: function(xhtR) {
                        $("#loader1").hide();
                        
                        $('#first-result').fadeIn('slow','linear',function(){
                            emp = xhtR.employee_id;
                            out = xhtR.no_of_outlets;
                            res = emp+out;
                            $(this).html(res);
                        });
                        
                         
                    },
                    error: function(){
                        $('#first-result').fadeIn('slow','linear',function(){
                            $(this).html("An error occurred. Try again!");
                        });
                        setTimeout(() => {
                            $('#first-result').html('').fadeOut('slow');
                        }, 10000);
                        $("#loader1").hide();
                    }
                
                });
            });

            $('#btnThird').click(function(){
                $("#loader3").show();
                var empid = $('#empidcreate').val();
                var no = $('#no').val();
                $.ajax({
                    url: 'api/createOutlets?id='+empid+'&no='+no,
                    type: 'POST',
                    success: function(xhtR) {
                        $("#loader3").hide();
                        $('#third-result').fadeIn('slow','linear',function(){
                            $(this).html(xhtR.status);
                        });
                    },
                    error: function(){
                        $("#loader3").hide();
                        $('#third-result').fadeIn('slow','linear',function(){
                            $(this).html("An error occurred. Try again!");
                        });
                        setTimeout(() => {
                                $('#third-result').html('').fadeOut('slow');
                            }, 10000);
                    }
                
                });
            });
        });

    </script>
</body>
</html>