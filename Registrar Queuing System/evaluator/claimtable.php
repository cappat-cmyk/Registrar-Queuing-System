<?php
session_start();

include "../DBConnect.php";
        
        $id=$_SESSION['id'];

        if(isset($_POST['updatedata']))
{

    $transact_id = $_POST['update_id'];

    $query = "UPDATE transactionhistory SET is_claimed='yes' WHERE transact_id='$transact_id'  ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo "<script> alert('Data Updated'); </script>";
        // header("Location:ManageUsers.php");
    }
    else
    {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Transactions</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    
    <style>
          tr {
            text-align: center;
        }
        td {
            cursor: pointer;
            font-size: 2rem;
            height:50px;
            text-align: center;
        }
    </style>
    
</head>
<body>

<div class="modal fade" id="updatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Set to Claimed? </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="update_id" id="update_id">

                        <h4> Are you sure you want to delete this user?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"> No </button>
                        <button type="submit" name="updatedata" class="btn btn-danger"> Yes </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<div class="container mt-3 mb-3">
    <div class="row">
        <div class="jumbotron" id="on-hold">
            <div class="card">
                <h2 class="ms-3"> Transactions for Claiming </h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <!--Updated3-1-22 eto yung pinalit ko sa table ng onhold transactions -->
                       <?php


               
                            $query = "SELECT * FROM transactionhistory WHERE is_claimed='no'";
                            $query_run = mysqli_query($conn, $query);
             

                        ?>
                    <table id="datatableid" class="table datatableid">
                        <thead>
                            <tr style="background-color: #012265; color: #FFDE00">
                                <th scope="col" hidden>ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Request Date</th>
                                <th scope="col">Claim Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                if($query_run)
                {
                    foreach($query_run as $row)
                    {$dateString = date('Y-m-d', strtotime($row['finishedAt']));
            ?>
                        <tbody>
                            <tr>
                                <td hidden> <?php echo $row['transact_id']; ?> </td>
                                <td> <?php echo $row['fullname']; ?> </td>
                                <td> <?php echo $dateString; ?> </td>
                                <td> <?php echo $row['claimDate']; ?> </td>
                                    
                                <td>
                                <button type="button" class="btn-primary btn-rounded btn-sm fw-bold updatebtn"> Mark as Claimed </button>
                      
                                </td>   
                            </tr>
                        </tbody>
                        <?php        
                        
                }
            }
               
                
            ?>
</table>
            </div>
        </div>
    </div>
</div>    
<script>
        $(document).ready(function () {

            $('.updatebtn').on('click', function () {

                $('#updatemodal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                console.log(data);

                $('#update_id').val(data[0]);

            });
        });
    </script>


</body>
</html>