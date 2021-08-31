<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap_2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap_2/css/style.css">
	 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="jquery_2/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script> -->
    <script src="bootstrap_2/js/bootstrap.min.js"></script>
	 <script src="bootstrap_2/js/bootstrap.min.js"></script>
	 <script src="ext/correction.js"></script>

    <title>Outlets Mapping</title>
	
	<style>


 #loaders,#loader,#loads{
   display:none
   
 }
 

</style>
	
	
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
                  <input type="text" class="form-control" id="dates_sarch" name="inlineFormOutlets" placeholder="Enter URNO">
                </div>

                <button type="submit" class="btn btn-primary mb-2" id="search_outlets">Find Outlets</button>
				 <img src="rot_small.gif" id="loaders" width="18" height="18" style="">
              </form>

              <hr>
              <span class="h5">Search Results</span>
              

              <table class="table">
              <thead>
                <tr>
                  <th class="h6" scope="col">OUTLET ID</th>
                  <th class="h6" scope="col">URNO</th>
                  <th class="h6" scope="col">Outlet Name</th>
                  <th class="h6" scope="col">Week Day</th>
                  <th class="h6" scope="col">Call Week</th>
            
                </tr>
              </thead>
              <tbody class="oulets_query_result">
             
                
         
              </tbody>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success">
              <center>Sales Route Details
            </div>
            <div class="card-body">
              <form class="form-inline">
                
                <label class="sr-only" for="inlineFormInputGroupUsername2"></label>
                <div class="input-group mb-2 mr-sm-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">#</div>
                  </div>
                  <input type="text" class="form-control" id="Upass" name="inlineFormOutlets" placeholder="Password">
				  <input type="text" class="form-control" id="Upin" name="inlineFormOutlets" placeholder="Pin">
                </div>

                <button type="submit" class="btn btn-primary mb-2" id="Esearch">Get Results</button>
				  <img src="rot_small.gif" id="loader" width="18" height="18" style="">
              </form>

              <hr>
              <span class="h5">Search Results</span>
              

              <table class="table">
              <thead>
                <tr>
                  <th class="h6" scope="col">Employee id</th>
                  <th class="h6" scope="col">Call Week</th>
				  <th class="h6" scope="col">Week Day</th>
                  <th class="h6" scope="col">Outlet Id</th>
                  <th class="h6" scope="col"></th>
                </tr>
              </thead>
              <tbody class="oulets_query_results ">
         
                
     
              </tbody>
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>