<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/style.css">
	 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <title>Outlets Mapping</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="card">
            <div class="card-header bg-info">
              <center>Outlet Details
            </div>
            <div class="card-body">
              <form class="form-inline">
                
                <label class="sr-only" for="inlineFormInputGroupUsername2">Outlets</label>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">E.g. xxx,xxx,xxx</div>
                  </div>
                  <input type="text" class="form-control" id="inlineFormOutlets" name="inlineFormOutlets" placeholder="Enter URNO">
                </div>

                <button type="submit" class="btn btn-primary mb-2">Find Outlets</button>
              </form>

              <hr>
              <span class="h5">Search Results</span>
              

              <table class="table">
              <thead>
                <tr>
                  <th class="h6" scope="col">Outlet Id</th>
                  <th class="h6" scope="col">Outlet Name</th>
                  <th class="h6" scope="col">Outlet ID</th>
                  <th class="h6" scope="col">Customer Name</th>
                  <th class="h6" scope="col">Week Day</th>
                  <th class="h6" scope="col">Call Week</th>
            
                </tr>
              </thead>
              <tbody id="outletresult">
                <div>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                  <td>@mdo</td>
                </tr>
                </div>
              </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success">
              <center>Link Rep to Outlets 
            </div>
            <div class="card-body">
              <form class="form-inline">
                
                <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">#</div>
                  </div>
                  <input type="text" class="form-control" id="inlineFormOutlets" name="inlineFormOutlets" placeholder="Enter ED/CPE Code">
                </div>

                <button type="submit" class="btn btn-primary mb-2">Get Results</button>
              </form>

              <hr>
              <span class="h5">Search Results</span>
              

              <table class="table">
              <thead>
                <tr>
                  <th class="h6" scope="col">Outlet Id</th>
                  <th class="h6" scope="col">Outlet Name</th>
                  <th class="h6" scope="col">Outlet ID</th>
                  <th class="h6" scope="col">Customer Name</th>
                  <th class="h6" scope="col">Week Day</th>
                  <th class="h6" scope="col">Call Week</th>
            
                </tr>
              </thead>
              <tbody id="employeeoutletresult">
                <div>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                  <td><input class="form-control form-control-sm" type="text"></td>
                  <td><button type="submit" class="btn-sm btn btn-primary">Map</button></td>
                </tr>
                </div>
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>