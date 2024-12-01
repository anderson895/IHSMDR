<?php 
include 'includes/header.php'; 
include 'includes/topbar.php'; 
include 'includes/sidebar.php'; 

include '../includes/config.php';

// Fetch maternal types and their names
$sql = "SELECT id, name, types FROM master_maternal";
$result = $conn->query($sql);

// Group data by types
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[$row['types']][] = $row;
    }
} else {
    echo "No data found!";
}

$id = $_GET['id']; // Patient ID

// Get patient details
$getUser = "SELECT * FROM patients WHERE id = '$id' ";
$user = $conn->query($getUser);
$patient = $user->fetch_assoc();

// Fetch selected maternal IDs for this patient
$selectedMaternalIdsQuery = "SELECT maternal_id FROM detail_patient_maternal WHERE patient_id = '$id'";
$selectedMaternalIdsResult = $conn->query($selectedMaternalIdsQuery);

$selectedMaternalIds = [];
if ($selectedMaternalIdsResult->num_rows > 0) {
    while ($row = $selectedMaternalIdsResult->fetch_assoc()) {
        $selectedMaternalIds[] = $row['maternal_id']; // Collect the selected maternal IDs
    }
}
?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>Patient Management</h4>
                <h6>View/Search Patients</h6>
            </div>
        </div>

        <form method="POST" action="save_patient_maternal.php">
            <input type="hidden" name="patient_id" value="<?php echo $id; ?>">

            <div class="card">
                <div class="card-body">
                <div class="form-group">
                    <label for="patient_no-name"><b>Patient No:</b></label>
                    <label id="patient_no-name"><?php echo htmlspecialchars($patient['patient_no']); ?></label>
                </div>

                <div class="form-group">
                    <label for="patient-name"><b>Patient Name:</b></label>
                    <label id="patient-name"><?php echo htmlspecialchars($patient['first_name'].' '.$patient['last_name']); ?></label>
                </div>

                <button type="submit" class="btn btn-primary">Save Selections</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                        <?php foreach ($data as $type => $items): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php echo $type === 1 ? 'active' : ''; ?>" id="tab-<?php echo $type; ?>" data-toggle="tab" href="#content-<?php echo $type; ?>" role="tab" aria-controls="content-<?php echo $type; ?>" aria-selected="true">
                                    Types <?php echo $type; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="myTabsContent">
                        <?php foreach ($data as $type => $items): ?>
                            <div class="tab-pane fade <?php echo $type === 1 ? 'show active' : ''; ?>" id="content-<?php echo $type; ?>" role="tabpanel" aria-labelledby="tab-<?php echo $type; ?>">
                                <div class="row mt-3">
                                    <?php foreach ($items as $item): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="<?php echo $item['id']; ?>" name="maternal_ids[]" id="maternal-<?php echo $item['id']; ?>" 
                                                    <?php echo in_array($item['id'], $selectedMaternalIds) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="maternal-<?php echo $item['id']; ?>">
                                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($item['name']); ?></p>
                                                   
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Selections</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include 'modal/patients/modal.php'; ?>
<?php include 'includes/footer.php'; ?>

<style>
    .card-body {
        padding: 20px; /* Adds padding inside the card body */
        background-color: #ffffff; /* Light gray background */
        border-radius: 8px; /* Rounded corners for a smoother appearance */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        margin-bottom: 15px; /* Adds space below the card */
        font-family: Arial, sans-serif; /* Sets font */
        font-size: 14px; /* Sets font size */
        color: #333; /* Sets text color */
    }

    .card-body h5 {
        font-size: 18px; /* Larger font size for card title */
        font-weight: bold; /* Bold text */
        margin-bottom: 10px; /* Space below the title */
    }

    .card-body p {
        font-size: 14px; /* Smaller font for paragraph text */
        color: #555; /* Darker gray color for readability */
    }

    .card-body .checkbox-container {
        margin-top: 10px; /* Space above the checkbox container */
    }

    .card-body .checkbox-container input[type="checkbox"] {
        margin-right: 5px; /* Space between checkbox and label */
    }

    .card-body .checkbox-container label {
        font-size: 14px; /* Ensures checkbox label matches the card text font size */
        color: #555; /* Ensures checkbox label has a darker gray color */
    }
</style>
