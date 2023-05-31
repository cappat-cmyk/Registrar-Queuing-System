<?php
session_start();
include "../DBConnect.php";
include "SideBar_UniversityRegistrar.php";
include "../SessionTimeout.php";


if (!isset($_SESSION['id'])) {
  header('Location: ../loginForm.php');
  exit();
}


if(isset($_POST['insertdata'])){
    $CourseAbbr=$_POST['CourseAbbr'];
    $Course = $_POST['inputcourse'];
    $EvaluatorId= '0';

    // Check if course abbreviation or course name already exists in the database
    $check_query = "SELECT * FROM courselist WHERE BINARY (CourseAbbr='$CourseAbbr' OR Course='$Course')";
    $check_query_run = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check_query_run) > 0) {
        // Course abbreviation or course name already exists, show error message
        echo '<script> alert("Course abbreviation or course name already exists"); </script>';
    } else {
        // Course abbreviation and course name do not exist, insert new data into the database
        $query = "INSERT INTO courselist(`CourseAbbr`,`Course`,`Evaluator_id` ) VALUES ('$CourseAbbr','$Course','$EvaluatorId')";
        $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            echo '<script> alert("Data Saved"); </script>';
            // header('Location: AddCourses.php');
        }
        else
        {
            echo '<script> alert("Data Not Saved"); </script>';
        }
    }
}
if(isset($_POST['updatedata'])){
    $CourseAbbr=$_POST['edit_courseabbr'];
    $Course = $_POST['edit_coursename'];
    $EvaluatorId= '0';
    $course_id = $_POST['update_id']; // assuming you have an ID field to uniquely identify the record to update

    // Check if course abbreviation or course name already exists in the database, excluding the current record being updated
    $check_query = "SELECT * FROM courselist WHERE BINARY (CourseAbbr='$CourseAbbr' OR Course='$Course') AND course_id != '$course_id'";
    $check_query_run = mysqli_query($conn, $check_query);

    if(mysqli_num_rows($check_query_run) > 0) {
        // Course abbreviation or course name already exists in another record, show error message
        echo '<script> alert("Course abbreviation or course name already exists"); </script>';
    } else {
        // Course abbreviation and course name do not exist, update the record in the database
        $query = "UPDATE courselist SET CourseAbbr='$CourseAbbr', Course='$Course' WHERE course_id='$course_id'";
        $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            echo '<script> alert("Data Updated"); </script>';
        }
        else
        {
            echo '<script> alert("Data Not Updated"); </script>';
        }
    }
}

if(isset($_POST['deletedata'])) {
     $course_id2= $_POST['delete_id'];
    
    $query = "DELETE FROM courselist WHERE course_id='$course_id2'";
    $query_run = mysqli_query($conn, $query);

    if($query_run) {
        echo '<script> alert("Data Deleted"); </script>';
        header("Location:AddCourses.php");
        exit();
    }
    else {
        echo '<script> alert("Data Not Deleted"); </script>';
        exit();
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Manage Programs/Department </title>
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
    <div class="modal fade" id="empaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header header-style">
                    <h5 class="modal-title" id="exampleModalLabel" >Add Programs/Strand </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">
                        <div class="form-group">
                            <label> Program/Strand</label>
                            <input type="text"   class="form-control shadow bg-body-tertiary rounded" name="inputcourse" id="inputcourse" placeholder="input new course here ">
                            <br>
                            <label> Program Abbreviation</label>
                            <input type="text"  class="form-control shadow bg-body-tertiary rounded" name="CourseAbbr" id="CourseAbbr" placeholder="Course Abbreviation ">                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="insertdata" class="btn btn-primary">Add Course</button>
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
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Course Data </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                


                        <form action="" method="POST">
                        <input type="hidden" name="update_id" id="update_id">
                  


                    <div class="modal-body">
                        <div class="form-group">
                            <label> Course Abbreviation </label>
                            <input type="text" id="edit_courseabbr" name="edit_courseabbr" class="form-control" placeholder="Enter Course Abbreviation">
                            <label> Course Name </label>
                            <input type="text" id="edit_coursename" name="edit_coursename" class="form-control" placeholder="Enter Course Name">
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
                    <h5 class="modal-title" id="exampleModalLabel"> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">
                <input type="hidden" name="delete_id" id="delete_id">
                    <div class="modal-body">
                        <h4> Proceed in deleting data?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> NO </button>             
                        <button type="submit" name="deletedata" class="btn btn-danger"> Yes! Delete it. </button>
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
                <h2> Manage Programs, Department, and Strand </h2>
            </div>
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#empaddmodal">
                        Add Program/Department
                    </button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <?php
                include "../DBConnect.php";

                $query = "SELECT * FROM courselist ORDER BY course_id ASC";
                $result = mysqli_query($conn, $query);
            ?>

<input type="search" placeholder="Search..." class="form-control search-input" data-table="datatableid"/><br>

<table id="datatableid" class="table datatableid">
                        <thead>
                            <tr style="background-color: #012265; color: #FFDE00">
                                <th scope="col" hidden>id</th>
                                <th scope="col">Program Abbreviation</th>
                                <th scope="col">Program/Strand</th>

                            
                                <th scope="col"> Action </th>
                            </tr>
                        </thead>
                        <?php
                if($result)
                {
                  while($row = mysqli_fetch_assoc($result)) 
                    {
            ?>        
                        <tbody>
                            <tr>
                                <td hidden> <?php echo $row['course_id']; ?> </td>
                                <td> <?php echo $row['CourseAbbr']; ?> </td>
                                <td> <?php echo $row['Course']; ?> </td>
                
                                <td>
                                    <button type="button" data-target= "#editmodal"class="btn btn-link btn-rounded btn-sm fw-bold editbtn"> EDIT </button><br>
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
  

    const radioButtons = document.querySelectorAll('input[name="role"]');
    radioButtons.forEach(radio => {
  radio.addEventListener('click', handleRadioClick);
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

        $('#update_id').val(data[0]);
        $('#edit_courseabbr').val(data[1]);
        $('#edit_coursename').val(data[2]);
    });
});
</script>
</body>
</html>