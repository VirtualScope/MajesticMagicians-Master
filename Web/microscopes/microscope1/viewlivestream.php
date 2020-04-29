<!DOCTYPE html>
<html lang="en">
<head>
<title>VirtualScope</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../../styles/streampage-style.css">
  <link rel="stylesheet" href="../../styles/navbar-style.css">

<?php
  require '../../includes/sessionsconfig.inc.php';
  require '../../includes/dbh.inc.php';
  require '../../includes/functions.inc.php';
  if(!$loggedIn){
    header("Location: ../../loginpage.php");
  }

  //Get the microscope name and query the database for microscope information
  $microscopeName = getMyMicroscopeName(dirname(__FILE__));
  $sql = "SELECT experiment_name, course_name, availability, youtube, description, state FROM microscopes WHERE microscope_name = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "s", $microscopeName);
  mysqli_stmt_execute($stmt);
  if(mysqli_stmt_bind_result($stmt, $col1, $col2, $col3, $col4, $col5, $col6)){
          mysqli_stmt_fetch($stmt);
          $experimentName = $col1; //Define the experiment name
          $className = $col2; // Define the course name
          $availability = $col3; // Define the availability
          $youtube = $col4; // Define the youtube link
          $description = $col5; // Define the description
          $state = $col6; // Get the state
          
          // Close the statement
          mysqli_stmt_close($stmt);
  } else{
      echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
  }
  
  // Close connection
  mysqli_close($conn);

  if($userType !='admin' && $state != "active"){
    header("Location: ../../microscopeunavailable.php");
  }

?>
  <script>

async function light(bool_arg){
	    $.ajax({
        url: "viewlivestrea.php",
        type: "GET",
        data: { device: "light", command: "switch", value: bool_arg },
        dataType: "json",
		//contentType: "application/json; charset=utf-8",
        success: function (result) {
            switch (result) {
                case true:
                    processResponse(result);
                    break;
                default:
                    resultDiv.html(result);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        //alert(xhr.status);
        //alert(thrownError);
        }
    });
}

async function zoom(){
  var t = document.getElementById("zoomInput");
  var x = parseFloat(t.value);
  console.log(x);
  if(x === 0 || isNaN(x)){
    alert("Zoom value cannot be equal to zero");
  }else{
    $.ajax({
        url: "viewlivestream.php",
        type: "GET",
        data: { device: "motor", command: "move", value: x },
        dataType: "json",
		//contentType: "application/json; charset=utf-8",
        success: function (result) {
            switch (result) {
                case true:
                    processResponse(result);
                    break;
                default:
                    resultDiv.html(result);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        //alert(xhr.status);
        //alert(thrownError);
        }
    });
  }
}


async function timer(){
  var t = document.getElementById("timerInput");
  var x = parseFloat(t.value);
  console.log(x);
  if(x <= 0 || isNaN(x)){
    alert("Timer value cant be under zero");
  }else{
    $.ajax({
        url: "./viewlivestream.php",
        type: "GET",
        data: { device: "light", command: "timer", value: x },
        dataType: "json",
		//contentType: "application/json; charset=utf-8",
        success: function (result) {
            switch (result) {
                case true:
                    processResponse(result);
                    break;
                default:
                    resultDiv.html(result);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
        //alert(xhr.status);
        //alert(thrownError);
        }
    });
  }
}

  </script>
</head>
<body>

<!-- Navigation -->
<?php include '../../navbar.php'; ?>

<!-- Content -->
<div class="container" style="margin-top:30px">
  <div class="row justify-content-center">
    <div class="col-9">
      <div class="card">
        <div class="card-body">
          <div class="videoWrapper">
            <!-- Put YOUTUBE link below -->
            <iframe width="560" height="349" src="<?php echo $youtube ?>" frameborder="0" allowfullscreen></iframe>
          </div>
          <hr>
            <div class="UserInterface" style="display:inline-block; padding-left:5px; padding-right:5px; " >
            <h3>Microscope Controls</h3>
            <div class="alert alert-danger" role="alert">If you or other users send multiple motor requests, the first one will be accepted and the rest will be ignored!</div>
            <p>Zoom Level Control (Positive or Negative Integer)</p>
              <div class="input-group mb-3">
                <input type="number" class="form-control" id="zoomInput" size="10" placeholder="Zoom Level" step="1">
                <div class="input-group-append">
                <button onclick="zoom()"  class="btn btn-danger button-addon">Zoom</button><br />
                </div>
              </div>
                <p>Light Timer Control (Max: 3 Minutes, Counted in fractions of a Minute)</p>
                <div class="input-group mb-3">
                <input type="number" class="form-control" value="0.1" min="0.1" max="3" step="0.1" size="10" placeholder="Minutes" id="timerInput">
                <div class="input-group-append">
                <button onclick="timer()" class="btn btn-warning">Set Timer</button><br />
                </div>
                <div class="btn-group-prepend btn-group-sm" role="group">
                </div></div>
                <div class="input-group mb-3">
                <button onclick="light(1)" style="margin:5px;" class="btn btn-warning">Light On</button>
                <button onclick="light(0)" style="margin:5px;" class="btn btn-dark">Light Off</button><br />
                </div>

            </div>
          <hr>
          <button class="normal_btn" name ="viewphoto-submit" type="submit" onclick="window.location.href='./viewphotos.php'">View Archived Photos</button>
          <button class="normal_btn" name ="googledocs-submit" type="submit" onclick="window.open('https://docs.google.com/forms/d/1Oa1WRS4LZLZQ9nuTjRTILW01rp9zHC7eG6cFWW6NvHs/edit')">Complete Experiment WorkSheet</button>
        </div>
      </div>
      <div class="card" style="margin-top: 30px; margin-bottom: 30px">
        <div class="card-header"><?php echo $experimentName; ?></div>
        <div class="card-body">
          <?php echo $description; ?>
        </div>
      </div>
    </div>
    <div class="col-3">
      <div class="card">
        <div class="card-header"><?php echo ucfirst($microscopeName); ?></div>
        <div class="card-body">
          <b>Experiment:</b>
          <p><?php echo $experimentName ?></p>
          <b>Class:</b>
          <p><?php echo $className ?></p>
          <b>Available:</b>
          <p><?php echo $availability ?></p>
        </div>
      </div>
      <div class="card" style="margin-top: 30px; margin-bottom: 30px">
        <div class="card-header">Latest Images</div>
        <div class="card-body">
          <a href="viewphotos.php" style="margin-top: -10px; float: right;">View all</a><br/>
          <?php 
          // Most recent images. parameters are (folder, number of images)
          displayLatest('./images', 3); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<?php include('../../footer.php');

include("config.php");
if (isset($_GET["device"]))
{
  $device = $_GET["device"]; # This needs to have input validation! Fortunately the Pi should has some, but that's not enough...
  $command = $_GET["command"];
  $value = $_GET["value"];
  $data;
  $data_string;
  try
  {
      if ($device === "motor")
          $data = array("device" => $device, "command" => "move", "value" => intval($value));         
      else if ($device === "light" && $command === "switch")
          $data = array("device" => "light", "command" => "switch", "value" => boolval($value));         
      else if ($device === "light" && $command === "timer")
          $data = array("device" => "light", "command" => "timer", "value" => floatval($value));         
      else
      {
          # echo '{"message" : "Invalid Input!"}'
          exit();
      }
      $data_string = json_encode($data);
      $ch = curl_init('http://' . $ip_address_of_this_raspberry_pi . ':5000/api/device/ '); 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
          'Content-Type: application/json',                                                                                
          'Content-Length: ' . strlen($data_string))                                                                       
      );                                                                                                                                                                                                                      
      curl_exec($ch); # Change to: echo curl_exec($ch); This can be used to return a value to the client, thus establishing a two-way communication.
      curl_close($ch);
  } catch(Exception $e)
  {
  #    echo '{"message" : ' . $e->getMessage() . '}'; # Use this to send the JSON {"message":"error message goes here"} which is what the web server sends as an error.
  }
}

?>

</body>
</html>
