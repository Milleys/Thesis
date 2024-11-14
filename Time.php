<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Series for Environmental Parameters</title>

 
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Luxon for Date manipulation in Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@2/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>

    <style>
        #time_chart{
            margin-bottom : 5%;
        }
    </style>
</head>
<body>
<div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <label for="parameterSelector" class="form-label">Select Parameter:</label>
                <select id="parameterSelector" class="form-select">
                    <option value="pH (units)">pH (units)</option>
                    <option value="Ammonia (mg/L)">Ammonia (mg/L)</option>
                    <option value="Inorganic Phosphate (mg/L)">Inorganic Phosphate (mg/L)</option>
                    <option value="BOD (mg/l)">BOD (mg/l)</option>
                    <option value="Total coliforms (MPN/100ml)">Total coliforms (MPN/100ml)</option>
                    <option value="Phytoplankton (cells/ml)">Phytoplankton (cells/ml)</option>
                </select>
            </div>
        </div>
    <div class="container mt-5">
        <div class="row">
            
        </div>

        <!-- Parameter Selection Dropdown -->
      

        <!-- Canvas for Chart -->
        <div class="row" id = "time_chart">
            <div class="col-md-12">
                <canvas id="paramChart" width="1100" height="500"></canvas>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    let paramChart;  // Declare a global variable for the chart instance
    let activeStation = null;  // Keep track of the active (highlighted) station

    // Fetch CSV data using PHP
    fetch('fetch.php')
        .then(response => response.json())
        .then(data => {
            const selectedStations = ["Stn XIII (Taytay)", "Stn V (Northern West Bay)", "Stn XIX (Muntinlupa)", "Stn. I (Central West Bay)", "Stn XV (San Pedro)", "Stn.XVI (Sta Rosa)"];  // Extract unique station names
            const parameterSelector = document.getElementById('parameterSelector');

            // Event listener for parameter change
            parameterSelector.addEventListener('change', function () {
                const selectedParameter = this.value;

                const datasets = selectedStations.map(station => {
                    const stationData = data.filter(row => row['Monitoring Stations'] === station);
                    
                    return {
                        label: station,  // Label for the station
                        data: stationData.map(row => ({
                            x: new Date(row['Date']),  // Date for the x-axis
                            y: parseFloat(row[selectedParameter])  // Selected parameter for the y-axis
                        })),
                        borderColor: getRandomColor(),  // Random color for each station
                        borderWidth: 2,  // Default border width
                        fill: false
                    };
                });

                // Calculate the minimum y-axis value dynamically for the selected parameter
                const minYValue = Math.min(...data.map(row => parseFloat(row[selectedParameter])));
                
                // Create or update the chart
                const ctx = document.getElementById('paramChart').getContext('2d');
                const chartConfig = {
                    type: 'line',
                    data: {
                        datasets: datasets  // Data for all stations
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'year'
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                beginAtZero: false,
                                suggestedMin: minYValue,  // Dynamically set minimum value based on selected parameter
                                title: {
                                    display: true,
                                    text: selectedParameter  // Dynamic y-axis label based on selected parameter
                                }
                            }
                        },
                        onClick: (e, activeEls) => {
                            if (activeEls.length > 0) {
                                const index = activeEls[0].datasetIndex;
                                highlightStation(index);
                            }
                        }
                    }
                };

                // If a chart instance exists, update it; otherwise, create a new one
                if (paramChart) {
                    paramChart.data = chartConfig.data;
                    paramChart.options = chartConfig.options;
                    paramChart.update();
                } else {
                    paramChart = new Chart(ctx, chartConfig);
                }
            });

            // Trigger initial load with the first parameter
            parameterSelector.dispatchEvent(new Event('change'));
        })
        .catch(error => console.error('Error fetching CSV data:', error));

    // Function to highlight the clicked station
    function highlightStation(index) {
        paramChart.data.datasets.forEach((dataset, i) => {
            if (i === index) {
                dataset.borderWidth = 5;  // Increase border width for the selected station
            } else {
                dataset.borderWidth = 2;  // Reset border width for others
            }
        });
        paramChart.update();  // Update the chart to reflect changes
    }

    // Utility function to generate random colors for each station
    function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>

</body>
</html>
