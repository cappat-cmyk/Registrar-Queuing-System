<?php
session_start();
include "../DBConnect.php";
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";

//Required Login
if (!isset($_SESSION['id'])) {
    echo'<script>alert("Please login.");</script>';
    header('Location: ../loginForm.php');
    exit();
  }
  
if(isset($_POST['insertdata']))
{
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$uname = $_POST['username'];
$pass = $_POST['password'];
$hash = password_hash($pass, PASSWORD_DEFAULT); 
$email = $_POST['Email'];
$role = "Evaluator";
$CounterNumber = $_POST['CounterNumber'];
$Created_At= date('Y-m-d H:i:s');

$select_query = "SELECT * FROM users WHERE BINARY (username='$uname' OR email='$email')";
$check_query_run = mysqli_query($conn, $select_query);


if(mysqli_num_rows($check_query_run) > 0) {
    // Course abbreviation or course name already exists, show error message
    echo '<script> alert("Username or Email already exists"); </script>';
} else {
    // Course abbreviation and course name do not exist, insert new data into the database
    $query = "INSERT INTO users(`First_Name`,`Last_Name`,`username`,`password`,`Email`,`role`,`CounterNumber` ) VALUES ('$fname','$lname','$uname','$hash','$email','$role','$CounterNumber')";
        $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Saved"); </script>';
        header('Location: ManageUsers.php');
        // exit();
    }
    else
    {
        echo '<script> alert("Data Not Saved"); </script>';
        // exit();
    }
}
}

elseif(isset($_POST['updatedata']))
{   
    $update_id = $_POST['update_id'];
    
    $fname = $_POST['edit_fname'];
    $lname = $_POST['edit_lname'];
    $email = $_POST['edit_email'];
    $CounterNumber = $_POST['edit_CounterNumber'];
    // $role = $_POST['role'];

    $select_query = "SELECT * FROM users WHERE BINARY (Email='$email')";
    $check_query_run = mysqli_query($conn, $select_query);
    
    if(mysqli_num_rows($check_query_run) > 0) {
        // If Username or Email already exists
        echo '<script> alert("Email already exists"); </script>';
    } else {
        // No Duplicate Email Update it in the database
        $query = "UPDATE users SET First_Name='$fname', Last_Name='$lname',Email='$email',CounterNumber='$CounterNumber' WHERE id='$update_id'";
        $query_run = mysqli_query($conn, $query);
    
        if($query_run)
        {
            echo '<script> alert("Data Saved"); </script>';
            // header('Location: ManageUsers.php');
            // exit();
        }
        else
        {
            echo '<script> alert("Data Not Saved"); </script>';
            // exit();
        }
    }
    }
elseif(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM users WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Deleted"); </script>';
        // header("Location:ManageUsers.php");
    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Manage Employee Data </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
</head>
<style>
.header-style{
  background-color: #FFDE00;

}
.banner {
    height: 80px;
    background-color: #012265;
    color:#FFDE00;
    text-align: center;
    font-size: 3rem;
    }
    </style>
<body>

    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="empaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-style">
                    <h5 class="modal-title" id="exampleModalLabel" >Add Employee Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label> First Name </label>
                            <input type="text" name="fname" class="form-control" placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" name="lname" class="form-control" placeholder="Enter Last Name">
                        </div>
                        <div class="form-group">
                            <label for="floatingUsername">Username</label>
                            <input type="text" class="form-control" id="username" name="username" id="Username" placeholder="Username">
                            
                        </div>

                    
                        <div class="form-group">
                        <label for="floatingPassword">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            
                        </div>

                        <div class="form-group">
                            <label> Email </label>
                            <input type="text" name="Email" class="form-control" placeholder="Enter Email">
                        </div>

                        <div class="form-group" id="counternumber">
                            <label id="lblcounternumber"> Counter Number </label>
                            <input type="number" name="CounterNumber" id="Counter Number" class="form-control" placeholder="Enter Counter Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Employee Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                            
                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <div class="form-group">
                            <label> First Name </label>
                            <input type="text" name="edit_fname" id="fname" class="form-control"
                                placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" name="edit_lname" id="lname" class="form-control"
                                placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label> Email </label>
                            <input type="text" name="edit_email" id="email" class="form-control"
                                placeholder="Enter Email">
                        </div>

                        <div class="form-group">
                            <label> CounterNumber </label>
                            <input type="text" name="edit_CounterNumber" id="CounterNumber" class="form-control"
                                placeholder="Enter CounterNumber">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- DELETE POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Delete Employee Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="delete_id" id="delete_id">

                        <h4> Are you sure you want to delete this user?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> NO </button>
                        <button type="submit" name="deletedata" class="btn btn-danger"> Yes I'm sure. </button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- VIEW POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
    

                <form action="deletecode.php" method="POST">

                    <div class="modal-body">

                        <input type="text" name="view_id" id="view_id">

                        <!-- <p id="fname"> </p> -->
                        <h4 id="fname"> <?php echo ''; ?> </h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> CLOSE </button>
                        <!-- <button type="submit" name="deletedata" class="btn btn-primary"> Yes !! Delete it. </button> -->
                    </div>
                </form>

            </div>
        </div>
    </div>


    <div class="container">
    
        <div class="jumbotron"> 
        <div class="card">
                <h2 class="ml-2"> Manage Users </h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#empaddmodal">
                        Add User
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <?php
                include "../DBConnect.php";

                $query = "SELECT * FROM users";
                $query_run = mysqli_query($conn, $query);
            ?>

<input type="search" placeholder="Search..." class="form-control search-input" data-table="datatableid"/><br>

                    <table id="datatableid" class="table datatableid">
                        <thead>
                            <tr style="background-color: #012265; color: #FFDE00">
                                <th scope="col" hidden>UserID</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name </th>
                                <th scope="col"> Email </th>
                                <th scope="col"> Role </th>
                                <th scope="col"> Counter Number</th>
            
                                <th scope="col"> Action </th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {
            ?>
                        <tbody>
                            <tr>
                                <td hidden> <?php echo $row['id']; ?> </td>
                                <td> <?php echo $row['First_Name']; ?> </td>
                                <td> <?php echo $row['Last_Name']; ?> </td>
                                <td> <?php echo $row['Email']; ?> </td>
                                <td> <?php echo $row['Role']; ?> </td>
                                <td> <?php echo $row['CounterNumber']; ?> </td>
                
                                <td>
                                    <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold editbtn"> EDIT </button><br>
                                    <button type="button" class="btn btn-link btn-rounded btn-sm fw-bold deletebtn"> DELETE </button>
                                </td>
                                
                            </tr>
                        </tbody>
                        <?php           
                    }
                }
                else 
                {
                    echo "No Record Found";
                }
            ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
  $(document).ready(function() {
  $('#empaddmodal').on('submit', '#addempform', function(e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    var type = form.attr('method');
    var data = form.serialize();

    $.ajax({
      url: url,
      type: type,
      data: data,
      success: function(response) {
        if (response.errors) {
          $('#error-message1').text(response.errors.username);
          $('#error-message2').text(response.errors.Email);
          $('#error-message3').text(response.errors.CounterNumber);
        } else {
          $('#empaddmodal').modal('hide');
          form.trigger('reset');
          $('#employeeTable').DataTable().ajax.reload();
        }
      }
    });
  });

  $('#empaddmodal').on('hidden.bs.modal', function (e) {
    $('#error-message1').text('');
    $('#error-message2').text('');
    $('#error-message3').text('');
  });
  
  $('#empaddmodal').on('show.bs.modal', function (e) {
    $('#addempform').trigger('reset');
  });
  
  $('#empaddmodal').on('hide.bs.modal', function (e) {
    if ($('#error-message1').text() !== '') {
      e.preventDefault();
      $('#empaddmodal').modal('show');
    }
  });
});
</script>





<script>
        (function(document) {
            'use strict';

            var TableFilter = (function(myArray) {
                var search_input;

                function _onInputSearch(e) {
                    search_input = e.target;
                    var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
                    myArray.forEach.call(tables, function(table) {
                        myArray.forEach.call(table.tBodies, function(tbody) {
                            myArray.forEach.call(tbody.rows, function(row) {
                                var text_content = row.textContent.toLowerCase();
                                var search_val = search_input.value.toLowerCase();
                                row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                            });
                        });
                    });
                }

                return {
                    init: function() {
                        var inputs = document.getElementsByClassName('search-input');
                        myArray.forEach.call(inputs, function(input) {
                            input.oninput = _onInputSearch;
                        });
                    }
                };
            })(Array.prototype);

            document.addEventListener('readystatechange', function() {
                if (document.readyState === 'complete') {
                    TableFilter.init();
                }
            });

        })(document);
    </script>
    

    <script>
        $(document).ready(function () {

            $('.deletebtn').on('click', function () {

                $('#deletemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#delete_id').val(data[0]);

            });
        });
    </script>

    <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#editmodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);
                $('#fname').val(data[1]);
                $('#lname').val(data[2]);
                $('#email').val(data[3]);
                $('#role').val(data[4]);
                $('#CounterNumber').val(data[5]);

            });
        });
    </script>


</body>
</html>