
document.addEventListener('DOMContentLoaded', function() {
    const dateFilter = document.getElementById('date-filter');
    const socialService = document.getElementById('socialService');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const filterBtn = document.getElementById('filter-btn');
    const financeChartCanvas = document.getElementById('financeChart');
    let financeChart = null;

    // Initialize date range picker
    $(startDate).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: { format: 'YYYY-MM-DD' }
    });

    $(endDate).daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: { format: 'YYYY-MM-DD' }
    });

    // Show/hide custom date range based on date filter selection
    dateFilter.addEventListener('change', function() {
        document.getElementById('custom-date-range').style.display = this.value === 'custom' ? 'block' : 'none';
    });

    // Fetch data and update chart
    function fetchFinanceData() {
        const dateFilterValue = dateFilter.value;
        const socialServiceValue = socialService.value;
        const startDateValue = $(startDate).val();
        const endDateValue = $(endDate).val();

        Swal.fire({
            title: 'Loading Data',
            text: 'Please wait while we fetch the data.',
            icon: 'info',
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'model/financial_budget/financeChart.php',
            method: 'POST',
            data: {
                dateFilter: dateFilterValue,
                socialService: socialServiceValue,
                startDate: startDateValue,
                endDate: endDateValue
            },
            dataType: 'json',
            success: function(response) {
                Swal.close(); // Close the loading indicator
                updateFinanceChart(response);
            },
            error: function() {
               
            }
        });
    }

    // Update the chart with new data
    function updateFinanceChart(data) {
        if (financeChart) {
            financeChart.destroy();
        }

        if (data && Array.isArray(data.expenditure)) {
            const labels = data.expenditure.map(item => item.socialService);
            const chartData = data.expenditure.map(item => parseFloat(item.monthly_expenditure.replace(',', '')));
            const totalExpenditure = chartData.reduce((total, amount) => total + amount, 0);

            document.getElementById('totalAmount').textContent = totalExpenditure.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const ctx = financeChartCanvas.getContext('2d');
            financeChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: ' ',
                        data: chartData,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Amount (PHP)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Social Service'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Expenditure by Social Service',
                            font: {
                                size: 18
                            }
                        },
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
                                }
                            }
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            formatter: (value) => value.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' }),
                            font: {
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: [ChartDataLabels]
            });

            // Remove existing buttons if any
            const existingButtons = document.querySelector('.download-buttons');
            if (existingButtons) {
                existingButtons.remove();
            }

            // Add download buttons
            addDownloadButtons();
        } else {
            document.getElementById('totalAmount').textContent = '0.00';
        }
    }

    function addDownloadButtons() {
        const buttonContainer = document.createElement('div');
        buttonContainer.className = 'download-buttons mt-2';
        
        const buttons = [
            { text: 'Download PDF', action: downloadPDF },
            { text: 'Download Excel', action: downloadExcel }
        ];

        buttons.forEach(button => {
            const btn = document.createElement('button');
            btn.textContent = button.text;
            btn.className = 'btn btn-primary me-2 btn-sm';
            btn.addEventListener('click', button.action);
            buttonContainer.appendChild(btn);
        });

        document.getElementById('charts').appendChild(buttonContainer);
    }



    function downloadPDF() {
        // Ensure jsPDF is available in the global scope
        if (typeof window.jspdf === 'undefined') {
            console.error('jsPDF library is not loaded');
            return;
        }

        const { jsPDF } = window.jspdf;

        const canvas = document.getElementById('financeChart');
        const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
        
        const pdf = new jsPDF('landscape');
        pdf.setFontSize(20);
        pdf.text('Expenditure by Social Service', 15, 15);
        
        // Calculate aspect ratio
        const imgProps = pdf.getImageProperties(canvasImage);
        const pdfWidth = pdf.internal.pageSize.getWidth() - 20;
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        
        pdf.addImage(canvasImage, 'JPEG', 10, 30, pdfWidth, pdfHeight);
        pdf.save('expenditure_chart.pdf');
    }

    function downloadExcel() {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Expenditure Data');

        // Add headers
        worksheet.addRow(['Social Service', 'Expenditure (PHP)']);

        // Add data
        financeChart.data.labels.forEach((label, index) => {
            worksheet.addRow([label, financeChart.data.datasets[0].data[index]]);
        });

        // Generate Excel file
        workbook.xlsx.writeBuffer().then(buffer => {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'expenditure_data.xlsx';
            link.click();
            URL.revokeObjectURL(link.href);
        });
    }

    // Attach event listener to filter button
    filterBtn.addEventListener('click', fetchFinanceData);

    // Initial fetch to load data when the page is first loaded
    fetchFinanceData();
});
