
document.addEventListener('DOMContentLoaded', function() {
    const pieChartCanvas = document.getElementById('pieChart');
    const allocatedAmount = document.getElementById('allocatedAmount');
    const spentAmount = document.getElementById('spentAmount');
    const remainingAmount = document.getElementById('remainingAmount');
    const downloadButtons = document.getElementById('download-buttons');
    let pieChart = null;

    // Fetch data and update chart and summary
    function fetchData() {
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
            url: 'model/financial_budget/pieChart.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                Swal.close(); // Close the loading indicator
                updateChart(response);
                updateSummary(response);
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'There was an error fetching the data.',
                    icon: 'error'
                });
            }
        });
    }

    // Update the pie chart with new data
    function updateChart(data) {
        if (pieChart) {
            pieChart.destroy();
        }

        const ctx = pieChartCanvas.getContext('2d');
        pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Allocated Budget', 'Spent Budget', 'Remaining Budget'],
                datasets: [{
                    label: 'Budget Distribution',
                    data: [data.allocated, data.spent, data.remaining],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' })}`;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Budget Distribution',
                        font: {
                            size: 18
                        }
                    }
                }
            }
        });

        addDownloadButtons(data);
    }

    // Update the budget summary section with new data
    function updateSummary(data) {
        allocatedAmount.textContent = data.allocated.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
        spentAmount.textContent = data.spent.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
        remainingAmount.textContent = data.remaining.toLocaleString('en-PH', { style: 'currency', currency: 'PHP' });
    }

    // Add download buttons for PNG, PDF, and Excel
    function addDownloadButtons(data) {
        downloadButtons.innerHTML = '';

        const buttons = [
            { text: 'Download PDF', action: () => downloadPDF(data) },
            { text: 'Download Excel', action: () => downloadExcel(data) }
        ];

        buttons.forEach(button => {
            const btn = document.createElement('button');
            btn.textContent = button.text;
            btn.className = 'btn btn-primary me-2 btn-sm';
            btn.addEventListener('click', button.action);
            downloadButtons.appendChild(btn);
        });
    }

   // Download the pie chart as PDF
   function downloadPDF(data) {
      const { jsPDF } = window.jspdf;

      const canvas = pieChartCanvas;
      const canvasImage = canvas.toDataURL('image/png');
      
      const pdf = new jsPDF();
      pdf.setFontSize(20);
      pdf.text('Budget Distribution', 10, 10);
      
      const imgProps = pdf.getImageProperties(canvasImage);
      const pdfWidth = pdf.internal.pageSize.getWidth() - 20;
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
      
      pdf.addImage(canvasImage, 'PNG', 10, 20, pdfWidth, pdfHeight);
      pdf.text(`Allocated Budget: ${data.allocated.toLocaleString()}`, 10, pdf.internal.pageSize.height - 50);
      pdf.text(`Spent Budget: ${data.spent.toLocaleString()}`, 10, pdf.internal.pageSize.height - 40);
      pdf.text(`Remaining Budget: ${data.remaining.toLocaleString()}`, 10, pdf.internal.pageSize.height - 30);
      pdf.save('budget_distribution.pdf');
   }

    // Download the pie chart data as Excel
    function downloadExcel(data) {
        const workbook = new ExcelJS.Workbook();
        const worksheet = workbook.addWorksheet('Budget Data');

        worksheet.addRow(['Category', 'Amount (PHP)']);
        worksheet.addRow(['Allocated Budget', data.allocated]);
        worksheet.addRow(['Spent Budget', data.spent]);
        worksheet.addRow(['Remaining Budget', data.remaining]);

        workbook.xlsx.writeBuffer().then(buffer => {
            const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'budget_data.xlsx';
            link.click();
            URL.revokeObjectURL(link.href);
        });
    }

    // Initial fetch to load data when the page is first loaded
    fetchData();
});