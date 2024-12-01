
$(document).ready(function() {
    // Function to fetch history list and populate the DataTable
    function fetchHistoryList(startDate = '', endDate = '') {
        if ($.fn.DataTable.isDataTable('#historyTable')) {
            $('#historyTable').DataTable().destroy();
        }

        var dataTable = $('#historyTable').DataTable({
            columns: [
                { data: 'history_id', title: 'History ID', orderable: true },
                { data: 'fullname', title: 'Name', orderable: true },
                { data: 'socialService', title: 'Social Service', orderable: true },
                { data: 'history_amountRedeem', title: 'Amount Redeemed', orderable: true },
                { data: 'history_status', title: 'Status', orderable: true },
                { data: 'history_date_redeemed', title: 'Date Redeemed', orderable: true }
            ]
        });

        $.ajax({
            url: 'model/history/fetch_.php',
            type: 'GET',
            dataType: 'json',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                dataTable.clear().rows.add(data).draw();
            },
            error: function(xhr, status, error) {
                console.error('Ajax request failed: ' + status + ', ' + error);
                $('#errorContainer').text('Error loading data: ' + error).show();
            }
        });
    }

    // Initialize date range picker
    $('#dateRange').daterangepicker({
        opens: 'left',
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    // Handle date range selection
    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
        fetchHistoryList(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });

    // Handle date range clear
    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        fetchHistoryList();
    });

    // Handle date filter change
    $('#date-filter').on('change', function() {
        var filterValue = $(this).val();
        var startDate = '';
        var endDate = '';

        switch (filterValue) {
            case 'thisWeek':
                startDate = moment().startOf('week').format('YYYY-MM-DD');
                endDate = moment().endOf('week').format('YYYY-MM-DD');
                break;
            case 'lastWeek':
                startDate = moment().subtract(1, 'week').startOf('week').format('YYYY-MM-DD');
                endDate = moment().subtract(1, 'week').endOf('week').format('YYYY-MM-DD');
                break;
            case 'thisMonth':
                startDate = moment().startOf('month').format('YYYY-MM-DD');
                endDate = moment().endOf('month').format('YYYY-MM-DD');
                break;
            case 'lastMonth':
                startDate = moment().subtract(1, 'month').startOf('month').format('YYYY-MM-DD');
                endDate = moment().subtract(1, 'month').endOf('month').format('YYYY-MM-DD');
                break;
            case 'custom':
                $('#custom-date-range').show();
                return; // Exit function to wait for custom date range input
            default:
                startDate = '';
                endDate = '';
        }

        fetchHistoryList(startDate, endDate);
    });
});
