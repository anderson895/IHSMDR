<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/phpmailer/src/SMTP.php';

include 'includes/config.php';
include 'Admin/controller/functions.php';

$userClass = new UsersClass($conn);
$users = $userClass->fetchAllUsers();

if (!empty($users)) {
    $mail = new PHPMailer(true);

    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ihsfmdr@gmail.com';           // Your Gmail address
        $mail->Password   = 'lpfkgzsnksnuafir';  // Gmail password or App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // From email address and name
        $mail->setFrom('ihsfmdr@gmail.com', 'IHSMDR');

        // Fetch medicines data
        $medicinesQuery = "SELECT * FROM medicines WHERE expiry_date < DATE_SUB(CURDATE(), INTERVAL 6 MONTH)"; // Adjust the query as necessary
        $medicinesResult = mysqli_query($conn, $medicinesQuery);

        // Check if query was successful
        if (!$medicinesResult) {
            die('Error fetching medicines: ' . mysqli_error($conn));
        }

        // Construct HTML table for medicines
        $htmlTable = '<h1>Upcoming Medicine Expiry Alert</h1>';
        $htmlTable .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">';
        $htmlTable .= '<tr><th>ID</th><th>Brand</th><th>Generic</th><th>Medicine Name</th><th>Expiry Date</th></tr>'; // Adjust the headers as necessary

        while ($med = mysqli_fetch_assoc($medicinesResult)) {
            $htmlTable .= '<tr>';
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_id']) . '</td>'; // Assuming 'id' is a field
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_brand']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['generic']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_name']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['expiry_date']) . '</td>';
            $htmlTable .= '</tr>';
        }
        $htmlTable .= '</table>';

        // Prepare the email content
      
        // Add each user to CC
        foreach ($users as $user) {
            $recipientEmail = $user['email'];
            $recipientName = $user['firstName'];
            $mail->addCC($recipientEmail); // Use addCC to send copies

            $mail->Subject = 'Medicines Notification';
            $mail->Body    = "Hello, $recipientName<br><br>This is a notification to inform you that the following medicines will expire within the next six months:<br>" . $htmlTable;
            $mail->isHTML(true); 
    
        }

        // Send email
        if ($mail->send()) {
            echo 'Message sent to all users.<br>';
        } else {
            echo 'Mailer Error: ' . $mail->ErrorInfo . '<br>';
        }

    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "No users to notify.";
}

// Close the database connection
$conn->close();
?>
