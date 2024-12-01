$(document).ready(function() {
    // Function to fetch financial budget list and populate the DataTable
    function fetchFinancialBudgetList() {
        if ($.fn.DataTable.isDataTable('#financialBudgetTable')) {
            $('#financialBudgetTable').DataTable().destroy();
        }
        var dataTable = $('#financialBudgetTable').DataTable({
            columns: [
                {
                    data: 'allocated_budget',
                    title: 'Allocated Budget',
                    orderable: true,
                    render: function(data, type, row) {
                        // Format the number as currency (peso) with comma separators and two decimal places
                        return parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
                    }
                },
                {
                    data: 'spent_budget',
                    title: 'Spent Budget',
                    orderable: true,
                    render: function(data, type, row) {
                        // Format the number as currency (peso) with comma separators and two decimal places
                        return parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
                    }
                },
                {
                    data: 'remaining_budget',
                    title: 'Remaining Budget',
                    orderable: true,
                    render: function(data, type, row) {
                        // Format the number as currency (peso) with comma separators and two decimal places
                        return parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
                    }
                },
                {
                    data: null,
                    title: 'Action',
                    orderable: false,
                    render: function(data, type, row) {
                        return '<div class="table-actions">' +
                            '<a class="me-3 edit-budget" href="javascript:void(0);" data-id="' + row.budget_id + '"><img src="assets/img/icons/edit.svg" alt="img"></a>' +
                            //'<a class="me-3 delete-budget" href="javascript:void(0);" data-budget-id="' + row.budget_id + '"><img src="assets/img/icons/delete.svg" alt="img"></a>' +
                            '</div>';
                    }
                }
            ]
            
        });

        $.ajax({
            url: 'model/financial_budget/fetch_.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                dataTable.clear().rows.add(data).draw();
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed: ' + status + ', ' + error);
                $('#errorContainer').text('Error loading data: ' + error).show();
            }
        });
    }

    fetchFinancialBudgetList();

    // Event handler for editing budget details
    $('#financialBudgetTable').on('click', '.edit-budget', function(e) {
        e.preventDefault();
        var budgetId = $(this).data('id');
        $.ajax({
            url: 'model/financial_budget/get_.php',
            type: 'GET',
            data: { budgetId: budgetId },
            dataType: 'json',
            success: function(data) {
                $('#editBudgetId').val(data.budget_id);
                $('#editAllocatedBudget').val(data.allocated_budget);
                $('#editSpentBudget').val(data.spent_budget);
                $('#editRemainingBudget').val(data.remaining_budget);
                $('#editBudgetModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching budget details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to fetch budget details.'
                });
            }
        });
    });

    // Event handler for updating budget details
    $('#saveEditBudget').on('click', function() {
        var formData = $('#editBudgetForm').serialize();

        $.ajax({
            url: 'model/financial_budget/edit_.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Budget updated successfully!'
                    }).then(function() {
                        $('#editBudgetModal').modal('hide');
                        fetchFinancialBudgetList();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating budget:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update budget.'
                });
            }
        });
    });

    // Event handler for deleting budget with SweetAlert confirmation
    $('#financialBudgetTable').on('click', '.delete-budget', function(e) {
        e.preventDefault();
        var budgetId = $(this).data('budget-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'model/financial_budget/del_.php',
                    type: 'POST',
                    data: { budgetId: budgetId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message
                            }).then(function() {
                                fetchFinancialBudgetList();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting budget:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete budget.'
                        });
                    }
                });
            }
        });
    });

    // Event handler for adding budget
    $('#addBudgetBtn').on('click', function() {
        $('#addBudgetModal').modal('show');
    });

    // Event handler for submitting add budget form
    $('#submitAdd').on('click', function() {
        var formData = $('#addBudgetForm').serialize();

        $.ajax({
            url: 'model/financial_budget/add_.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Budget added successfully!'
                    }).then(function() {
                        $('#addBudgetModal').modal('hide');
                        fetchFinancialBudgetList();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error adding budget:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to add budget.'
                });
            }
        });
    });
});


