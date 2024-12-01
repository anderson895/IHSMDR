
$(document).ready(function() {
    loadPhilippineData();
    initEventListeners();
});

function loadPhilippineData() {
    $.ajax({
        url: 'https://raw.githubusercontent.com/flores-jacob/philippine-regions-provinces-cities-municipalities-barangays/master/philippine_provinces_cities_municipalities_and_barangays_2019v2.json',
        dataType: 'json',
        success: function(data) {
            localStorage.setItem('philippineData', JSON.stringify(data));
            populateProvinces(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching data:', error);
            Swal.fire('Error', 'Unable to load location data. Please try again later.', 'error');
        }
    });
}

function populateProvinces(data) {
    const provinceDropdown = $('#province');
    provinceDropdown.empty().append('<option value="">Select Province</option>');
    const targetProvince = 'AKLAN';

    $.each(data, function(regionCode, region) {
        $.each(region.province_list, function(provinceName) {
            if (provinceName === targetProvince) {
                provinceDropdown.append(`<option value="${provinceName}">${provinceName}</option>`);
            }
        });
    });
}

function populateMunicipalities() {
    const selectedProvince = $('#province').val();
    const data = JSON.parse(localStorage.getItem('philippineData'));
    const municipalityDropdown = $('#municipality');
    municipalityDropdown.empty().append('<option value="">Select Municipality</option>');

    if (selectedProvince === 'AKLAN') {
        $.each(data, function(regionCode, region) {
            const province = region.province_list[selectedProvince];
            if (province) {
                $.each(province.municipality_list, function(municipalityName) {
                    municipalityDropdown.append(`<option value="${municipalityName}">${municipalityName}</option>`);
                });
            }
        });
    }
}

function populateBarangays() {
    const selectedProvince = $('#province').val();
    const selectedMunicipality = $('#municipality').val();
    const data = JSON.parse(localStorage.getItem('philippineData'));
    const barangayDropdown = $('#barangay');
    barangayDropdown.empty().append('<option value="">Select Barangay</option>');

    if (selectedProvince === 'AKLAN' && selectedMunicipality) {
        $.each(data, function(regionCode, region) {
            const province = region.province_list[selectedProvince];
            if (province) {
                const municipalities = province.municipality_list[selectedMunicipality];
                if (municipalities) {
                    $.each(municipalities.barangay_list, function(index, barangayName) {
                        barangayDropdown.append(`<option value="${barangayName}">${barangayName}</option>`);
                    });
                }
            }
        });
    }
}

function responseHandler(res) {
    if (res.success && res.data) {
        return {
            total: parseInt(res.data.total, 10),
            rows: res.data.data
        };
    } else {
        console.error('Error fetching data:', res.message || 'Unknown error');
        return {
            total: 0,
            rows: []
        };
    }
}

function operateFormatter(value, row, index) {
return [  
     `<a class="history btn btn-info text-white btn-sm" href="javascript:void(0)" title="View History">
        <i class="fas fa-history"></i>
    </a>`,
    `<a class="edit btn btn-secondary text-white btn-sm" href="javascript:void(0)" title="Edit">
        <i class="fas fa-edit"></i>
    </a>`,
    `<a class="remove btn btn-danger text-white btn-sm" href="javascript:void(0)" title="Remove">
        <i class="fas fa-trash"></i>
    </a>`,
 
].join(' ');
}

window.operateEvents = {
    'click .edit': function(e, value, row, index) {
        showCitizenModal(row);
    },
    'click .remove': function(e, value, row, index) {
        deleteCitizen(row.citizen_id);
    },
    'click .history': function(e, value, row, index) {
        $.ajax({
            url: 'model/citizen/history.php', // Replace with your endpoint
            method: 'GET',
            data: { citizen_id: row.citizen_id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const historyTable = $('#historyTable tbody');
                    historyTable.empty(); // Clear any existing data

                    response.data.forEach(function(entry) {
                        historyTable.append(`
                            <tr>
                                <td>${entry.fullname}</td>
                                <td>${entry.socialService}</td>
                                <td>${entry.endorsedBy}</td>
                                <td>${entry.amountRedeem}</td>
                                <td>${entry.date_redeemed}</td>
                                <td>${createDownloadLinks(entry.uploadFilePath)}</td> <!-- Add download links -->
                            </tr>
                        `);
                    });

                    $('#historyModal').modal('show');
                } else {
                    Swal.fire('Error', response.message || 'An unknown error occurred', 'error');
                }
            },
            error: function(jqXHR) {
                console.log(jqXHR.responseText); // Log the response text to the console for debugging
                Swal.fire('Error', 'An unknown error occurred', 'error');
            }
        });
    }
};

// Function to handle the download link creation
function createDownloadLinks(filePaths) {
    var fileLinks = '';
    var files = JSON.parse(filePaths); // Parse JSON string to get file paths

    for (var type in files) {
        if (files.hasOwnProperty(type)) {
            var fileName = files[type];
            fileLinks += `<br><a href="../files/${fileName}" download class="btn btn-link  btn-sm me-1">
                            <i class="fa fa-download"></i> ${type.replace(/([A-Z])/g, ' $1').trim()}
                          </a>`;
        }
    }

    return fileLinks || '<span>No files available</span>';
}


function initEventListeners() {
    $('#addCitizenBtn').on('click', function() {
        showCitizenModal();
    });

    $('#citizenForm').on('submit', function(event) {
        event.preventDefault();
        saveCitizen();
    });

    $('#province').change(function() {
        populateMunicipalities();
        $('#barangay').empty().append('<option value="">Select Barangay</option>');
    });

    $('#municipality').change(function() {
        populateBarangays();
    });
}

function showCitizenModal(citizen = null) {
$('#citizenForm')[0].reset(); // Reset the form
$('#citizenModalLabel').text(citizen ? 'Edit Citizen' : 'Register a New Citizen');

// Clear dropdowns
$('#province').empty().append('<option value="">Select Province</option>');
$('#municipality').empty().append('<option value="">Select Municipality</option>');
$('#barangay').empty().append('<option value="">Select Barangay</option>');

if (citizen) {
    // Set citizen details
    $('#citizenId').val(citizen.citizen_id);
    $('#firstName').val(citizen.first_name);
    $('#lastName').val(citizen.last_name);
    $('#middleName').val(citizen.middle_name);
    $('#suffix').val(citizen.suffix);
    $('#birthdate').val(citizen.birthdate);
    $('#gender').val(citizen.gender);
    $('#headOfFamily').val(citizen.headOfFamily);
    $('#familyMembers').val(citizen.familyMembers);
    $('#mobileNo').val(citizen.mobile_no);
    $('#email').val(citizen.email);
    $('#address').val(citizen.address);
    $('#sector').val(citizen.sector);
    $('#registeredVoter').val(citizen.registered_voter);
    $('#religion').val(citizen.religion);
    $('#affiliation').val(citizen.affiliation);

    populateProvinces(JSON.parse(localStorage.getItem('philippineData')));
    $('#province').val(citizen.province);

    populateMunicipalities();
    $('#municipality').val(citizen.municipality);

    populateBarangays();
    $('#barangay').val(citizen.barangay);

    // Display current file names for IDs and images if they exist
    if (citizen.front_valid_id) {
        $('#frontValidIdLabel').text(`Current: ${citizen.front_valid_id}`);
        $('#frontValidIdImage').attr('src', `../uploads/${citizen.front_valid_id}`);
    }

    if (citizen.back_valid_id) {
        $('#backValidIdLabel').text(`Current: ${citizen.back_valid_id}`);
        $('#backValidIdImage').attr('src', `../uploads/${citizen.back_valid_id}`);
    }

    // Show the uploaded ID section
    $('.uploaded-id-section').show();
} else {
    populateProvinces(JSON.parse(localStorage.getItem('philippineData')));

    // Hide the uploaded ID section for new citizens
    $('.uploaded-id-section').hide();
}

// Image modal preview
$('#imageModal').on('show.bs.modal', function(event) {
    const button = $(event.relatedTarget);
    const imgSrc = button.attr('src');
    const imgAlt = button.attr('alt');

    $('#modalImage').attr('src', imgSrc);
    $('#imageModalLabel').text(imgAlt);
});

// Show the modal
$('#citizenModal').modal('show');
}



function saveCitizen() {
const formData = new FormData($('#citizenForm')[0]);
const action = $('#citizenId').val() ? 'update' : 'create';
formData.append('action', action);

Swal.fire({
    title: 'Saving Citizen...',
    allowOutsideClick: false,
    didOpen: () => {
        Swal.showLoading();
    }
});

$.ajax({
    url: 'model/citizen/crud.php',
    method: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function(response) {
        console.log(response); // Log the response to the console for debugging
        Swal.close();
        if (response.success) {
            Swal.fire('Success', response.message, 'success');
            $('#citizenModal').modal('hide');
            $('#table').bootstrapTable('refresh');
        } else {
            Swal.fire('Error', response.message || 'An unknown error occurred', 'error');
        }
    },
    error: function(jqXHR) {
        Swal.close();
        console.log(jqXHR.responseText); // Log the response text to the console for debugging
        try {
            const errorResponse = JSON.parse(jqXHR.responseText);
            Swal.fire('Error', errorResponse.message || 'An unknown error occurred', 'error');
        } catch (e) {
            Swal.fire('Error', 'An unknown error occurred', 'error');
        }
    }
});
}


function deleteCitizen(citizenId) {
Swal.fire({
    title: 'Are you sure?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            url: 'model/citizen/crud.php',
            method: 'POST',
            data: {
                action: 'delete',
                citizen_id: citizenId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire('Deleted!', response.message, 'success');
                    $('#table').bootstrapTable('refresh');
                } else {
                    Swal.fire('Error', response.message || 'An unknown error occurred', 'error');
                }
            },
            error: function(jqXHR) {
                Swal.close();
                try {
                    const errorResponse = JSON.parse(jqXHR.responseText);
                    Swal.fire('Error', errorResponse.message || 'An unknown error occurred', 'error');
                } catch (e) {
                    Swal.fire('Error', 'An unknown error occurred', 'error');
                }
            }
        });
    }
});
}
