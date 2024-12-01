<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4"  style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
            <h4>Manager Account List</h4>
            <h6>View/Search Manager Accounts</h6>
            </div>  <div class="page-btn">
                <!-- Button to trigger modal -->
                <button class="btn btn-added" data-bs-toggle="modal" data-bs-target="#adduserModal">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Add Manager
                </button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <!-- Filter options can be added here -->
                </div>
                <div class="table-responsive">
                <table id="dataTable" class="table hover nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be appended here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- js -->
    <?php include 'includes/footer.php'; ?>
    <?php include 'modal/manager/add_.php'; ?>
    <?php include 'modal/manager/edit_.php'; ?>
    <script src="ajax/managerAccounts.js"></script>