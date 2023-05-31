<?php

session_start();
include '../DBConnect.php';

$usertype="Student";
?>

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
        button{
          background-color: #012265;
          border-style: none;
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
#search-results {
  list-style: none;
  margin: 0;
  padding: 0;
}

#search-results li {
  padding: 5px;
  background-color: #f7f7f7;
  border-bottom: 1px solid #ddd;
}

#search-results li:hover {
  background-color: #e6e6e6;
  cursor: pointer;
}
.form-label {
  text-align: left;
}


    
    </style>
</head>
<body>

  <!-- title of the transaction type -->
  <div class="text-center mt-10" >
    <h1 style="color:#FFDE00; font-size: calc(100% + 3vw + 3vh);;">Transaction Type</h1>
  </div>
    
  <!-- container for buttons -->
  <div class="d-flex justify-content-center align-items-center text-center" style="width:100%;">
        <div class="row row-cols-2 row-cols-lg-2 align-items-stretch g-4 py-5">

          <!-- div for request -->
            <button type="button" class="col" id="request" data-bs-toggle="modal" value="request">
              <div class="p-3">
                  <img class="img-fluid" src="../images/file logo.png"><br>
                  <span class="text-white" >Request</span>
              </div>
            </button>
        
          <!-- div for claim -->
          <button type="button" class="col" id="claim" data-bs-toggle="modal" value="claim">
            <div class="p-3">
                <img class="img-fluid" src="../images/hand logo.png"><br>
                <span class="text-white">Claim</span>
            </div>
          </button>

          <!-- div for others -->


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
          <input type="hidden" id="hiddentransaction" name="hiddentransaction" value="<?php echo $usertype?>">
          <input type="hidden" id="requesttype" name="requesttype">

            <!-- For StudentID textfield -->
            <div class="mb-3" id="StudentID">
              <label for="InputStudentID" class="form-label">StudentID</label>
              <input type="text" class="form-control" id="search" name="search" placeholder="Please type your StudentID" required>
              <div id="search-results"></div>
            </div>

            <!-- For email textfield -->
            <div class="mb-3" id="EmailAddress">
              <label for="InputStudentID" class="form-label">Email address</label>
              <input type="email" class="form-control" id="txtfld_EmailAddress" name="txtfld_EmailAddress" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>

            
            <!-- Select Request Credentials -->
            <label for="InputStudentID" class="form-label" id="credentialrequestlabel">Credential to Request</label>
            <select class="form-select form-select-md" aria-label=".form-select-sm example" id="RequestCredentials" name="RequestCredentials" required>
            <?php
                    $result = $conn->query("SELECT * FROM credentials ORDER BY credential ASC");

                    // Get the selected item
                    $selected = isset($_POST['credential']) ? $_POST['credential'] : '';
                    
                    // Generate the option elements
                    while ($row = $result->fetch_assoc()) {
                      $id = $row['id'];
                      $name = $row['credential'];
                      $selectedAttr = $id == $selected ? 'selected' : '';
                      echo "<option value='$id' $selectedAttr>$name</option>";
                    }

                   ?>
            </select>





            <!-- For pwd select -->
            <div id="PWDSelect" class="mt-3">
              <label class="form-label" for="">Are you PWD?</label><br>
              <div class="form-check parent-container">
              <label class="form-check-label" for="pwdoptions1">
                
              <div class="btn btn-block square-button mx-2 d-flex flex-column align-items-center justify-content-center">
                <img class="img-fluid" style="max-width: 150px; max-height: 150px;" src="../images/priority.png" alt="yes"> 
                <span class="pwdspan text-center">Priority</span>
              </div>
                  <input type="radio" class="form-check-input"  name="pwdoptions" id="pwdoptions1" value="yes">
                </label>
                  


                <label class="form-check-label" for="pwdoptions2">        
               
                <div class="btn btn-block square-button d-flex align-items-center justify-content-center" style="border: solid #53ED00 5px; border-radius: 10px; ">
                <img class="img-fluid" style="max-width: 200px; max-height: 200px;" id="icons"src="../images/notpriority.png" alt="no">
              <span style="color:#53ED00">Not Priority</span>
                  </div>
                  <input type="radio" class="form-check-input"  name="pwdoptions" id="pwdoptions2" value="no"> 
                
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

$(document).ready(function() {
    $('#search').on('input', function() {
        var query = $(this).val();
        $.ajax({
            url: 'autocomplete.php',
            type: 'POST',
            data: {query: query},
            success: function(data) {
                $('#search-results').html(data).show();
                $('#search-results li').on('click', function() {
                    var selected = $(this).text().split(' ')[0]; // extract student ID
                    $('#search').val(selected);
                    $('#search-results').empty();
                });
            }
        });
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search-container').length) {
            $('#search-results').hide();
        }
    });
});




</script>




  <script>
  
  const myForm = document.getElementById('clientregistrationform');
  const submit = document.getElementById('submit');
  window.history.pushState(null, null, window.location.href);
    window.onpopstate = function () {
        window.history.go(1);
    };

    // Request button and request values
    $("#request").on( "click", function() {
      $('#Modal').modal('show');  
        $('#StudentID').show();
        $('#EmailAddress').show();
        $('#VerificationCode').hide();
        $('#RequestCredentials').show();
        $('#OthersCredentials').hide();
        $('#RequestCredentials').disabled=false;
        $('#PWDSelect').show();
        $('#credentialrequestlabel').show();

        $("#requesttype").val("Request");


  });


  // Claim Button and Claim Values
  $("#claim").on( "click", function() {
    $('#Modal').modal('show'); 
        $('#StudentID').hide();
        $('#EmailAddress').hide();
        $('#VerificationCode').show();
        $('#RequestCredentials').hide();
        $('#RequestCredentials').disabled=true;
        $('#OthersCredentials').hide();
        $('#PWDSelect').show();
        $('#credentialrequestlabel').hide();

        $("#requesttype").val("Claim");
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

  if ((hiddentransaction == "Student") && isChecked) {
    var form = document.getElementById("clientregistrationform");
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