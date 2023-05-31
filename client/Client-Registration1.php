<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Transaction</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/jquery.min.js"></script>


    <style>
        body{
            background-color: #012265;
            height:100%;
            margin-top:10%;
        }
        .p-3{
          border: solid #FFDE00 5px;
          border-radius: 10px;
        }
        span{
          font-size: calc(100% + 0.5vw + 0.5vh);
        }
        a, a:hover{ 
          color: inherit; 
        }
        .col{
          background-color: #012265;
          border-style: none;
        }
        .priority {
          background-color: white;
          
        }
        .square-button {
  width: 200px;
  height: 200px;
  border: solid #00b5ff 5px;
  border-radius: 10px;
  
  display: inline-flex;
}
.square-button:active {
  background-color: #00b5ff;
  border-color: #012265;
}
.parent-container {
  display: flex;
  justify-content: center; /* this centers the child elements horizontally */
  align-items: center; /* this centers the child elements vertically */
}

.pwdspan {
  display: block;
 
}
        input[type=radio] {
          display: none;
        }

        label img {
  cursor: pointer;
}
/* input[type=radio]:checked + .square-button {
  background-color: #00b5ff;
  color: white;
}

input[type=radio]:checked + .square-button .pwdspan {
  color: white;
} */
    </style>
</head>
<body>

  <!-- title of the transaction type -->
  <div class="text-center mt-10" >
    <h1 style="color:#FFDE00; font-size: calc(100% + 3vw + 3vh);;">Customer Type</h1>
  </div>
    
  <!-- container for buttons -->
  <div class="d-flex justify-content-center align-items-center text-center" style="width:100%;">
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">

          <!-- div for request -->
            <button type="button" class="col" id="student" name="CRStudent"  value="CRStudent">
              <div class="p-3">
                  <img class="img-fluid" src="../images/graduated.png"><br>
                  <span class="text-white">Student</span>
              </div>
            </button>
        
          <!-- div for claim -->
          <button type="button" class="col" id="faculty" data-bs-toggle="modal" value="RCFaculty">
            <div class="p-3">
                <img class="img-fluid" src="../images/employee.png"><br>
                <span class="text-white">Faculty/Employees</span>
            </div>
          </button>

          <!-- div for others -->
          <button type="button" class="col" id="others" data-bs-toggle="modal" value="others">
            <div class="p-3">
                <img class="img-fluid" src="../images/guests.png"><br>
                <span class="text-white">Others</span>
            </div>
          </button>
        </div>
  </div>

  <!-- This is the modal for all the transactions -->
  <div class="modal fade" tabindex="-1" id="Modal" aria-labelledby="modal_request" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_request">Please Fill up:</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="clientregistrationform" method="post">

            <!-- hidden input to send on the courseselect (request, claim, others) -->
            
          <input type="hidden" id="hiddentransaction" name="hiddentransaction">

            <!-- For pwd select -->
            <div id="PWDSelect" class="mt-3">
              <!-- <label class="form-label" for="">Are you PWD?</label><br> -->
              <div class="form-check parent-container">
              <label class="form-check-label" for="pwdoptions1">
                
              <div class="btn btn-block square-button mx-2 d-flex flex-column align-items-center justify-content-center" style="border: solid #00B5FF 5px; border-radius: 10px; ">
              <input type="radio" class="form-check-input"  name="pwdoptions" id="pwdoptions1" value="yes">
              <img class="img-fluid" style="max-width: 150px; max-height: 150px;" src="../images/priority.png" alt="yes"> 
              <span class="pwdspan text-center">Priority</span>
            </div>
                            
                </label>
                  


                <label class="form-check-label" for="pwdoptions2">        
                <input type="radio" class="form-check-input"  name="pwdoptions" id="pwdoptions2" value="no"> 
                <div class="btn btn-block square-button d-flex align-items-center justify-content-center" style="border: solid #53ED00 5px; border-radius: 10px; ">
                <img class="img-fluid" style="max-width: 200px; max-height: 200px;" id="icons"src="../images/notpriority.png" alt="no">
              <span style="color:#53ED00">Not Priority</span>
                  </div>
                 
                
                </label>
              
            </div>
              
          </form>
    </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="submit">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <script>
  window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.go(1);
    };

    // student values
    $("#student").on( "click", function() {
      $("#hiddentransaction").val("Student");

      window.location.href = "Client-RegistrationStudent.php";
    
  });


  // Claim Button and Claim Values
  $("#faculty").on( "click", function() {
    $('#Modal').modal('show'); 
        $('#StudentID').hide();
        $('#EmailAddress').hide();
        $('#VerificationCode').hide();
        $('#RequestCredentials').hide();
        $('#PWDSelect').show();

        $("#hiddentransaction").val("Faculty");
  });


  // Others button and value
  $("#others").on( "click", function() {
      $('#Modal').modal('show');  
        $('#StudentID').hide();
        $('#EmailAddress').hide();
        $('#VerificationCode').hide();
        $('#RequestCredentials').hide();
        $('#PWDSelect').show();

        $("#hiddentransaction").val("Others");
  });

  $("#submit").on("click", function() {
  var hiddentransaction = document.getElementById("hiddentransaction").value;
  var pwdoptions = document.getElementsByName("pwdoptions");

  // Check if a radio button is selected
  var isChecked = false;
  for (var i = 0; i < pwdoptions.length; i++) {
    if (pwdoptions[i].checked) {
      isChecked = true;
      break;
    }
  }

  if ((hiddentransaction == "Faculty" || hiddentransaction == "Others") && isChecked) {
    var form = document.getElementById("clientregistrationform");
    console.log(hiddentransaction);

    // set the new action for the form
    form.action = "CourseSelect.php";

    // submit the form
    form.submit();
  }
  else{
    alert("Choose if priority or not");
  }
 
});




  </script>
</body>
</html>