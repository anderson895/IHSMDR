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
        $medicinesQuery = "SELECT * FROM medicines WHERE quantity <= 100"; // Adjust the query as necessary
        $medicinesResult = mysqli_query($conn, $medicinesQuery);

        // Check if query was successful
        if (!$medicinesResult) {
            die('Error fetching medicines: ' . mysqli_error($conn));
        }

        // Construct HTML table for medicines
        // $htmlTable = '<h1>Low Stock Alert: Medicine Quantity Below 100</h1>';
        $htmlTable .= '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">';
        $htmlTable .= '<tr><th>ID</th><th>Brand</th><th>Generic</th><th>Medicine Name</th><th>Quantity</th><th>Expiry Date</th></tr>'; // Adjust the headers as necessary

        while ($med = mysqli_fetch_assoc($medicinesResult)) {
            $htmlTable .= '<tr>';
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_id']) . '</td>'; // Assuming 'id' is a field
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_brand']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['generic']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['medicine_name']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['quantity']) . '</td>';
            $htmlTable .= '<td>' . htmlspecialchars($med['expiry_date']) . '</td>';
            $htmlTable .= '</tr>';
        }
        $htmlTable .= '</table>';

       
        // Add each user to CC
        foreach ($users as $user) {
            $recipientEmail = $user['email'];
            $recipientName = $user['firstName'];
            $mail->addCC($recipientEmail); // Use addCC to send copies

                // Prepare the email content
            $mail->Subject = 'Low Stock Alert: Medicine Quantity Below 100';
            $mail->Body    = "Hello, $recipientName <br><br>We want to bring to your attention that the stock levels for the following medicines have dropped to 100 units or fewer:<br>" . $htmlTable;
            $mail->isHTML(true); // Set email format to HTML

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
