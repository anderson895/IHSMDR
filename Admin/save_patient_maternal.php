<?php

include '../includes/config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $patient_id = $_POST['patient_id'];
    $maternal_ids = $_POST['maternal_ids'];

   
    if (!empty($maternal_ids)) {

        // First, delete existing maternal records for the given patient_id
        $patient_id = $conn->real_escape_string($patient_id);

        $delete_sql = "DELETE FROM detail_patient_maternal WHERE patient_id = '$patient_id'";

        if (!$conn->query($delete_sql)) {
            echo "Error deleting previous records: " . $conn->error;
            exit; // Stop the script if delete fails
        }

        // Now, insert the new maternal records
        foreach ($maternal_ids as $maternal_id) {
            // Escape inputs to prevent SQL injection
            $maternal_id = $conn->real_escape_string($maternal_id);

            // Construct the SQL query for insertion
            $insert_sql = "INSERT INTO detail_patient_maternal (patient_id, maternal_id) VALUES ('$patient_id', '$maternal_id')";

            // Execute the insert query
            if (!$conn->query($insert_sql)) {
                echo "Error inserting data: " . $conn->error;
                exit; // Stop the script if insert fails
            }
        }

        // Show success alert and go back to the previous page
        echo "<script type='text/javascript'>
                alert('Data saved successfully!');
                window.history.back(); // Go back to the previous page
            </script>";
    } else {
        // Show error if no maternal items were selected
        echo "<script type='text/javascript'>
                alert('No maternal items selected.');
                location.reload(); // Reload the page
              </script>";
    }

}

$conn->close();
?>
