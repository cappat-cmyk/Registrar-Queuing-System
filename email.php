<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require 'vendor/autoload.php';

include "../DBConnect.php";
$email = $_POST['email'];


    // //Check if the email exists in the database
    // $result = $conn->query("SELECT * FROM users WHERE Email = '$email'");
    // if ($result->num_rows > 0) {
    //     $user = $result->fetch_assoc();
    // } else {
    //     echo "No user found with email: " . $email;
    // }
    
    // // Generate a new password
    // $newPassword = generateNewPassword();
    // // Hash the new password
    // $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    // // Create a token
    // $token = bin2hex(random_bytes(32));
    // // Save the token and the new hashed password in the database
    // $conn->query("UPDATE users SET reset_password = '$token', password = '$hashedPassword' WHERE email = '$email'");
    // // Send an email to the user with a link to reset their password
    // sendResetPasswordEmail($email, $token);
    // echo json_encode(['message' => 'An email has been sent to your email address']);


    //Create an instance; passing `true` enables exceptions

if(isset($_POST["email"])){
        $date = $_POST['claimdate'];
        $mail = new PHPMailer(true);

        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
''
        $mail->Username = 'cjalmendral123@gmail.com'; // YOUR gmail email
        $mail->Password = 'pmoxtfzpkuuxdvkt'; // YOUR gmail password

        // Sender and recipient settings
        $mail->setFrom('cjalmendral123@gmail.com', 'CJ');
        $mail->addAddress($email, 'Cj Almendral');

        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = "Claim/Verification Code";
        $mail->Body = "Claim $date";
        $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
        $mail->send();
        echo "Email message sent.";
        echo '<script>
            alert("Email Sent Successfully"); </script>';
        echo("<script>window.location = '../evaluator/EvaluatorPage.php';</script>");
    } 
//Generate random 8 digit code
    // function generateClaimCode() {
    //     $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    //     $code = array();
    //     $alphaLength = strlen($alphabet) - 1;
    //     for ($i = 0; $i < 8; $i++) {
    //         $n = rand(0, $alphaLength);
    //         $code[] = $alphabet[$n];
    //     }
    //     return implode($code);
    // }
    
?>
