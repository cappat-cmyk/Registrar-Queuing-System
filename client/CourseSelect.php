<?php
include "../DBConnect.php";
session_start();
$usertype=$_POST['hiddentransaction'];
$pwdoptions="";
$requesttype="";
$studentid="";
$EmailAddress="";
$RequestCredentials="";

        if ($usertype=='Faculty'||$usertype=='Others') {
            $pwdoptions=$_POST['pwdoptions'];
        }
        elseif($usertype=="Student"){
            $requesttype=$_POST['requesttype'];

            //get all the fields from the student upon request
            if($requesttype=="Request"){
                $studentid=$_POST['search'];
                $EmailAddress=$_POST['txtfld_EmailAddress'];
                $RequestCredentials=$_POST['RequestCredentials'];
                $pwdoptions=$_POST['pwdoptions'];        
            }
            elseif($requesttype=="Claim"){
                $pwdoptions=$_POST['pwdoptions']; 
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="../jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../jquery/print.min.js"></script>

   
    <style>

    *{
        text-align:center;
    }
    body{
        background-color: #012265;
    }
    h1{
        color: #FFDE00;
    }
    .div-design{
        background-color: #FFDE00;
        color:#012265;
        height:6em;
        width:17em;
    
    }
    .icon-size{
        height: 5em;
        width: 5em;
    }
    .icon-size1{
        height: 6em;
        width: 4em;
    }
    
    </style>

</head>
<body>
    <div class="container">
<a href="Client-Registration1.php"><img role="button" src="../IMAGES/back-arrow logo.png" class="mt-2 img-fluid img-circle rounded float-start icon-size"></a>

<a><img role="button" src="../IMAGES/UPHSL logo.png" class="mt-2 img-fluid img-circle rounded float-end icon-size1 "></a>
    
</div>

    <h1 class="lead display-3 text-center fw-bold mt-5">Select Department</h1>
    
    <?php
  
                    $result = $conn->query("SELECT course_id, course FROM courselist ORDER BY Course ASC");

                    //iterate all the items
                    echo "<div class='row cols-sm-1 cols-md-1 cols-lg-4 g-4 py-4 fw-bold ' style='font-size:17px;'>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<a style='text-decoration:none;' class='course col-sm-3 d-flex align-items-center' role='button'>";
                        echo "<div style='line-height:1.5;' class='p-3 border border-3 border-light rounded-3 div-design' id=" . $row['course_id'].">".$row['course']."</div>";
                        echo "</a>";
                    }
                    
                    echo " </div>";
    ?>

    


<script>
    // select all elements with class 'data-element'
    var dataElements = document.querySelectorAll("a");

    for (var i = 0; i < dataElements.length; i++) {
        dataElements[i].addEventListener("click", function(event) {
        var chosenCourse = event.target.getAttribute("id");
        
        var usertype="<?php echo $usertype?>";
        var pwdornot="<?php echo $pwdoptions?>";
        var requesttype="<?php echo $requesttype?>";
        var studentid="<?php echo $studentid?>";
        var emailAddress="<?php echo $EmailAddress?>";
        var requestCredentials="<?php echo $RequestCredentials?>";

        // console.log(usertype,chosenCourse,pwdornot,requesttype,studentid,emailAddress,requestCredentials);


        $.ajax({
    url: "verification.php",
    type: "POST",
    data: {
        course: chosenCourse,
        usertype: usertype,
        pwdornot: pwdornot,
        requesttype: requesttype,
        studentid: studentid,
        emailAddress: emailAddress,
        requestCredentials: requestCredentials
    },
    success: function(data) {
        data = data.replace(/"/g, '');
        console.log(data);
        window.location.href = "printticket.php?data=" + data;

    //     $.ajax({
    //         url: "printticket.php",
    //         type: "POST",
    //         data: {
    //             ticketnumber: data,
    //         },
    //         success: function(response) {
    //             console.log(response);
    //         },
    //         error: function(xhr, textStatus, errorThrown) {
    //             console.error("Failed to send request to print.php", errorThrown);
            }
    //     });
    // },
    // error: function(xhr, textStatus, errorThrown) {
    //     console.error("Failed to send request to verification.php", errorThrown);
    // }
});

    });
}

</script>

    
</body>
</html>