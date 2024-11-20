<?php
include "status_backend.php";
include "chart.php";
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap css link -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Css Paths -->
    <link rel="stylesheet" href="styles/header.css">
    <link rel="stylesheet" href="styles/footer.css">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/status.css">
    <!-- Add this in the <head> tag for Bootstrap CSS -->
   


    <!-- table Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=table_chart" />


    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Luxon for Date manipulation in Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@2/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>

    <style>

        /*table Icon Design*/

       
        .material-symbols-outlined {
           float: left;
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24;
            color: gray; /* Set icon color to green */
            cursor: pointer;
        }

       






        /* Main container styling */
        .chart-container-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 480px;
            /* Set a maximum width for larger screens */
            margin: 20px auto;
            /* Center the charts horizontally and add some margin */
        }

        /* Chart container styling */
        .chart-container {
            width: 100%;
            max-width: 100%;
            /* Make the chart container responsive */
            height: 300px;
            /* Adjust height for visibility */
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            display: none;
            /* Hidden by default */
        }

        /* Show only the active chart */
        .chart-container.active {
            display: block !important;
            /* Show the active chart */
            z-index: 10;
        }

        /* Styling for Navigation Buttons */
        .chart-buttons {
            display: flex;
            gap: 10px;
            /* Space between the buttons */
            justify-content: center;
            align-items: center;
            margin-top: 10px;
            /* Adjust the top margin as needed */
        }

        .chart-buttons button {
            padding: 8px 16px;
            border: 1px solid #ccc;
            cursor: pointer;
            transition: background-color 0.5s;
            border-radius: 5px;
        }

        .chart-buttons button:hover {
            background-color: #28a745;
        }

        /* Ensure the chart stacks below the map on smaller screens */
        @media (max-width: 768px) {
            .chart-container-wrapper {
                max-width: 100%;
                margin-top: 20px;
                margin-left: 0;
            }

            .chart-buttons {
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>


</head>

<body>

    <!-- HEADER nav bar start -->
    <?php include 'new_header.php'; ?>
    <!-- HEADER nav bar end -->

    <!-- main content start -->
    <main>

    <!-- Progress Modal -->
    <div id="modal">
            <div id="modal-content">
                <h4>Prediction in progress</h4>
                <div id="progress-container">
                    <div id="progress-bar"></div>
                </div>
            </div>
        </div>


     <!-- 
        <div id="loading-screen">
            
            <dotlottie-player src="https://lottie.host/d283b94d-6898-4495-9883-cdc6ada3e7b5/79Vf6zVZPx.json"
                background="transparent" speed="1" style="width: 300px; height: 300px;" loop autoplay>
            </dotlottie-player>
        </div>
        -->

        <div class="container mt-5">
            <div class="row">
                <!-- Date Prediction Section -->
                <div class="col-md-9">
                    <div class="prediction-box">
                        <h4>Date Prediction</h4>
                        <form method="get" action="status.php">
                            <label for="date" class="form-label">Choose a date:</label>
                            <input type="date" id="date" class="form-control mb-3" name="date"
                                min="<?php echo min($dates); ?>" max="<?php echo max($dates); ?>"
                                value="<?php echo isset($_GET['date']) ? $_GET['date'] : date('Y-m-d', strtotime('+1 day')); ?>">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success" value="Forecast">Forecast</button>
                            </div>
                        </form>
                        <form action="status.php" method="post">
                            <div class="btn-group">
                                <button type="submit" class="btn btn-success" value="Predict" id = "open-modal-btn">Predict</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="legend mt-4">
                    <h5>Legend</h5>
                    <ul class="list-unstyled">
                        <li><span style="color: green;">●</span> Minor</li>
                        <li><span style="color: orange;">●</span> Moderate</li>
                        <li><span style="color: red;">●</span> Massive</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 d-flex">
                <!-- Map Container -->
                <div class="map-container me-3">
                    <div class="report-image image-container mb-3">
                        <img src="assets/LLDA-MAPPED.png" alt="Quarterly Report" class="img-fluid">
                        <svg class="svg-overlay" viewBox="0 0 600 600" preserveAspectRatio="xMidYMid meet">
                            <!-- Define gradients -->
                            <defs>

                                <radialGradient id="circleGradient" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                                    
                                </radialGradient>

                                <radialGradient id="no_green" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                                    <stop offset="0%" style="stop-color: rgba(0, 255, 24, 1); stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: rgba(0, 255, 24, 0); stop-opacity: 0" />
                                </radialGradient>

                               
                                <radialGradient id="green" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                                    <stop offset="0%" style="stop-color: rgba(0, 255, 24, 1); stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: rgba(0, 255, 24, 0); stop-opacity: 0" />
                                </radialGradient>


                                <radialGradient id="orange" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                                    <stop offset="0%" style="stop-color: rgba(255, 173, 0, 1); stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: rgba(255, 173, 0, 0); stop-opacity: 0" />
                                </radialGradient>

                                <radialGradient id="red" cx="50%" cy="50%" r="50%" fx="50%" fy="50%">
                                    <stop offset="0%" style="stop-color: rgba(217, 0, 0, 1); stop-opacity: 1" />
                                    <stop offset="100%" style="stop-color: rgba(217, 0, 0, 0); stop-opacity: 0" />
                                </radialGradient>

                                
                            </defs>
                            <circle class="clickable-circle" cx="307" cy="63" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_XIII" id="circle_XIII">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>

                            <circle class="clickable-circle" cx="366" cy="133" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_V" id="circle_V">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>

                            <circle class="clickable-circle" cx="466" cy="352" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_I" id="circle_XIX">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>

                            <circle class="clickable-circle" cx="240" cy="365" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_XIX" id="circle_I">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>

                            <circle class="clickable-circle" cx="233" cy="493" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_XV" id="circle_XV">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>

                            <circle class="clickable-circle" cx="346" cy="635" r="100" fill="url(#circleGradient)"
                                data-bs-toggle="modal" data-bs-target="#Station_XVI" id="circle_XVI">
                                <animate attributeName="r" values="45;55;45" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="fill-opacity" values="0.5;1;0.5" dur="2s" repeatCount="indefinite"/>
                            </circle>
                            
                        </svg>
                    </div>
                </div>

                <!-- Chart Section -->
                <div class="chart-container-wrapper">
                    <h1>Weather Forecast</h1>
                    <!-- Charts Container -->
                    <div class="chart-container mb-3" id="temperatureChartContainer">
                        <canvas id="temperatureChart"></canvas>
                    </div>
                    <div class="chart-container mb-3" id="humidityChartContainer">
                        <canvas id="humidityChart"></canvas>
                    </div>
                    <div class="chart-container mb-3" id="windChartContainer">
                        <canvas id="windChart"></canvas>
                    </div>
                    

                    <!-- Navigation Buttons -->
                    <div class="chart-buttons d-flex justify-content-center mt-2">
                        <button onclick="prevChart()" class="btn btn-success me-2"><b>&lt;</b></button>
                        <button onclick="nextChart()" class="btn btn-success"><b>&gt;</b></button>
                    </div>
                </div>
            </div>
        </div>


    </main>
       <!-- main content end -->
    <div class="container mt-5">
    <h1>Time Series Data</h1>
    </div>
 
    <div class="container mt-5">
    <div class="row">
      
    </div>
        <div id = "TimeChart" class="col-md-12">



        </div>
    </div>

    <!-- Station_XIII -->
    <div class="modal fade" id="Station_XIII" tabindex="-1" aria-labelledby="minorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="minorModalLabel">Stn XIII (Taytay)</h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                       
                   
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn XIII (Taytay)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                        // Round off the prediction to the nearest whole number
                        $rounded_prediction = round($phyto[$station_to_display]);

                        if($rounded_prediction < 0){
                            
                            echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                        }else{
                            echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                        }
                        

                        // Send the prediction value to JavaScript for dynamic color change
                        echo "<script>
                                var roundedPrediction = $rounded_prediction;
                                changeCircleColor(roundedPrediction, 'circle_XIII');

                                function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                                </script>";
                            
                        if($rounded_prediction <= 0){
                            echo "<b>No signs of algal blooms.</b>";
                        }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                            echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } else{
                            echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                        }
                    } else {
                        echo "No prediction available for " . $station_to_display . "\n";
                    }

                    ?>
                    <!--To Here-->
                </div>

                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn XIII (Taytay)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                         

                            

                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData = json_encode($filteredData);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year" class="form-select" onchange="filterData()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>



                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Station_V -->
    <div class="modal fade" id="Station_V" tabindex="-1" aria-labelledby="moderateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="moderateModalLabel">Stn V (Northern West Bay) </h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn V (Northern West Bay)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                        // Round off the prediction to the nearest whole number
                        $rounded_prediction = round($phyto[$station_to_display]);

                        if($rounded_prediction < 0){
                            
                            echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                        }else{
                            echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                        }
                        

                        // Send the prediction value to JavaScript for dynamic color change
                        echo "<script>
                                var roundedPrediction = $rounded_prediction;
                                changeCircleColor(roundedPrediction, 'circle_V');

                              function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                                </script>";
                            
                        if($rounded_prediction <= 0){
                            echo "<b>No signs of algal blooms.</b>";
                        }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                            echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } else{
                            echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                        }
                    } else {
                        echo "No prediction available for " . $station_to_display . "\n";
                    }

                    ?>
                    <!--To Here-->
                </div>


                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn V (Northern West Bay)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData2[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData2 = json_encode($filteredData2);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year2" class="form-select" onchange="filterData2()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table2">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Station_XIX -->
    <div class="modal fade" id="Station_XIX" tabindex="-1" aria-labelledby="massiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massiveModalLabel">Stn XIX (Muntinlupa)</h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn XIX (Muntinlupa)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                       // Round off the prediction to the nearest whole number
                       $rounded_prediction = round($phyto[$station_to_display]);

                       if($rounded_prediction < 0){
                           
                           echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                       }else{
                           echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                       }
                       

                       // Send the prediction value to JavaScript for dynamic color change
                       echo "<script>
                               var roundedPrediction = $rounded_prediction;
                               changeCircleColor(roundedPrediction, 'circle_XIX');

                             function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                               </script>";
                           
                       if($rounded_prediction <= 0){
                           echo "<b>No signs of algal blooms.</b>";
                       }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                           echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                       }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                           echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                       } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                           echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                       } else{
                           echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                       }
                   } else {
                       echo "No prediction available for " . $station_to_display . "\n";
                   }

                    ?>
                    <!--To Here-->

                </div>


                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn XIX (Muntinlupa)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData3[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData3 = json_encode($filteredData3);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year3" class="form-select" onchange="filterData3()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table3">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Station_I -->
    <div class="modal fade" id="Station_I" tabindex="-1" aria-labelledby="massiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massiveModalLabel">Stn. I (Central West Bay)</h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn. I (Central West Bay)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                        // Round off the prediction to the nearest whole number
                        $rounded_prediction = round($phyto[$station_to_display]);

                        if($rounded_prediction < 0){
                            
                            echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                        }else{
                            echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                        }
                        

                        // Send the prediction value to JavaScript for dynamic color change
                        echo "<script>
                                var roundedPrediction = $rounded_prediction;
                                changeCircleColor(roundedPrediction, 'circle_I');

                              function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                                </script>";
                            
                        if($rounded_prediction <= 0){
                            echo "<b>No signs of algal blooms.</b>";
                        }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                            echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } else{
                            echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                        }
                    } else {
                        echo "No prediction available for " . $station_to_display . "\n";
                    }

                    ?>
                    <!--To Here-->
                </div>

                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn. I (Central West Bay)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData4[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData4 = json_encode($filteredData4);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year4" class="form-select" onchange="filterData4()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table4">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Station_XV -->
    <div class="modal fade" id="Station_XV" tabindex="-1" aria-labelledby="massiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massiveModalLabel">Stn XV (San Pedro)</h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn XV (San Pedro)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                        // Round off the prediction to the nearest whole number
                        $rounded_prediction = round($phyto[$station_to_display]);

                        if($rounded_prediction < 0){
                            
                            echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                        }else{
                            echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                        }
                        

                        // Send the prediction value to JavaScript for dynamic color change
                        echo "<script>
                                var roundedPrediction = $rounded_prediction;
                                changeCircleColor(roundedPrediction, 'circle_XV');

                               function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                                </script>";
                            
                        if($rounded_prediction <= 0){
                            echo "<b>No signs of algal blooms.</b>";
                        }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                            echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } else{
                            echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                        }
                    } else {
                        echo "No prediction available for " . $station_to_display . "\n";
                    }
                    ?>
                    <!--To Here-->
                </div>



                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn XV (San Pedro)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData5[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData5 = json_encode($filteredData5);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year5" class="form-select" onchange="filterData5()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table5">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Station_XVI -->
    <div class="modal fade" id="Station_XVI" tabindex="-1" aria-labelledby="massiveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="massiveModalLabel">Stn.XVI (Sta Rosa)</h5>
                    <span class="material-symbols-outlined" onclick="toggleModalBody()">table_chart</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!--Prediction from here-->
                    <?php
                    $station_to_display = 'Stn.XVI (Sta Rosa)'; // Replace 'Station Name' with the actual station name you want to display
                    if (isset($phyto[$station_to_display])) {
                        // Round off the prediction to the nearest whole number
                        $rounded_prediction = round($phyto[$station_to_display]);

                        if($rounded_prediction < 0){
                            
                            echo "<b>Prediction for " . $station_to_display . ":</b> 0 cells/mL<br>";
                        }else{
                            echo "<b>Prediction for " . $station_to_display . ":</b> " . $rounded_prediction . " cells/mL<br>";
                        }
                        

                        // Send the prediction value to JavaScript for dynamic color change
                        echo "<script>
                                var roundedPrediction = $rounded_prediction;
                                changeCircleColor(roundedPrediction, 'circle_XVI');

                               function changeCircleColor(prediction, circleId) {
                                                let fill = '';
                                               if (prediction <= 0) {
                                                    fill = 'url(#no_green)';  // No impact or below
                                                } else if (prediction > 0 && prediction <= 50000) {
                                                    fill = 'url(#green)';  // Minimal impact (0 to 50,000)
                                                } else if (prediction >= 50001 && prediction <= 100000) {
                                                    fill = 'url(#green)';  // Moderate impact (50,001 to 100,000)
                                                } else if (prediction >= 100001 && prediction <= 500000) {
                                                    fill = 'url(#orange)';  // Significant impact (100,001 to 500,000)
                                                } else {
                                                    fill = 'url(#red)';  // Severe impact (500,000+)
                                                }

                                                // Change the circle color
                                                document.getElementById(circleId).setAttribute('fill', fill);
                                            }
                                </script>";
                            
                        if($rounded_prediction <= 0){
                            echo "<b>No signs of algal blooms.</b>";
                        }elseif ($rounded_prediction > 0 && $rounded_prediction <= 50000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        }elseif ($rounded_prediction >= 50001 && $rounded_prediction <= 100000) {
                            echo "<b>Minor:</b> Minimal or no noticeable impact on water quality. Some visible bloom may be present, but effects on aquatic life are typically limited.<br> <br> <b>Fish Kill: </b> Generally safe no immediate threat to fish. Counts in this range typically indicate healthy water conditions with minimal risk of oxygen depletion or harmful toxin production.<br> <br> <b>Prescription : </b>No action needed; water is safe with no immediate threats to aquatic life. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } elseif ($rounded_prediction >= 100001 && $rounded_prediction <= 500000) {
                            echo "<b>Moderate:</b> Visible bloom with potential moderate impacts on water quality, including reduced oxygen levels. Potentially harmful to aquatic ecosystems.<br> <br> <b>Fish Kill: </b> Elevated phytoplankton levels that could start to affect water quality. At this range, there is a moderate risk of mild hypoxia (low oxygen) and possible mild toxicity depending on the phytoplankton species present. <br> <br> <b>Prescription : </b>Monitor water quality closely, especially dissolved oxygen and temperature. Watch for any signs of fish stress and prepare to intervene if needed. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers.</p>";
                        } else{
                            echo "<b>Massive:</b> Severe bloom with significant impacts, including potential toxin production, severe oxygen depletion, and major disruptions to aquatic life and water usability. <br> <br> <b>Fish Kill:</b>  Extremely high risk of severe fish kills due to oxygen depletion and high levels of toxins. This level is usually associated with intense HABs capable of widespread ecological damage. <br> <br> <b>Prescription : </b>Intensify water monitoring and consider mitigation actions like aeration. Notify local agencies if harmful species are detected. <br><br> <p> Note: Not all phytoplankton are harmful; many species are essential for the ecosystem, but certain types can produce toxins or deplete oxygen, leading to fish kills when present in high numbers. </p>";
                        }
                    } else {
                        echo "No prediction available for " . $station_to_display . "\n";
                    }
                    ?>
                    <!--To Here-->
                </div>


                <div class="new-modal-body m-3" style="display: none;">
                    <?php
                        $station_to_display = 'Stn.XVI (Sta Rosa)'; // Replace with your actual station name
                        if (isset($phyto[$station_to_display])) {
                            // Round off the prediction to the nearest whole number
                            $rounded_prediction = round($phyto[$station_to_display]);
                        }
                        $rounded_prediction = isset($rounded_prediction) ? $rounded_prediction : 'No prediction available';
                        
                        // Loop through the data and filter rows based on month, year, and specific station
                        foreach ($csvData as $row) {
                            $row = array_combine($header, $row);
                            
                            // Filter by current month and specific station
                            if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === $station_to_display ) {
                                if ($selectedYear === 'All' || $row['Year'] == $selectedYear) {
                                    $filteredData6[] = [
                                        'phytoplankton count' => $row['Phytoplankton (cells/ml)'],
                                        'year' => $row['Year'],
                                        'station' => $row['Monitoring Stations'],
                                        'months' => $row['Month']
                                    ];
                                }
                            }
                        }
                        $jsonData6 = json_encode($filteredData6);
                    ?>

                    <!-- Year selection dropdown -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year6" class="form-select" onchange="filterData6()">
                            <option value="All">All</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Create a container for both tables side by side -->
                    <div class="d-flex justify-content-between">

                        <!-- Predicted Phytoplankton Count Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Predicted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $rounded_prediction; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phytoplankton Data Table -->
                        <div class="table-container flex-fill" style="max-width: 48%; overflow-x: auto; overflow-y: auto; max-height: 300px;">
                            <table class="table table-bordered" id="data-table6">
                                <thead>
                                    <tr>
                                        <th>Previous Count</th>
                                        <th>Year</th>
                                        <th>Station</th>
                                        <th>Month</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be generated dynamically by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <script src="script/modal-progress.js"></script>


    <!-- FOOTER Section Start -->
    <?php include 'footer.php'; ?>
    <!-- FOOTER Section End -->


    <!-- Bootstrap JS Bundle (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript to control the loading screen -->
     <!-- <script src="script/loadingscreen.js"></script>-->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- phyto table -->
<script>
  function toggleModalBody() {
    // Select all modal-body and new-modal-body elements
    const modalBodies = document.querySelectorAll('.modal-body');
    const newModalBodies = document.querySelectorAll('.new-modal-body');
    
    console.log("Toggle function called"); // Check if function is called
    
    // Loop through all modal-body elements
    modalBodies.forEach(modalBody => {
        if (modalBody.style.display === 'none') {
            modalBody.style.display = 'block'; // Show modal-body
            console.log("Showing modal-body");
        } else {
            modalBody.style.display = 'none'; // Hide modal-body
            console.log("Hiding modal-body");
        }
    });
    
    // Loop through all new-modal-body elements
    newModalBodies.forEach(newModalBody => {
        if (newModalBody.style.display === 'none') {
            newModalBody.style.display = 'block'; // Show new-modal-body
            console.log("Showing new-modal-body");
        } else {
            newModalBody.style.display = 'none'; // Hide new-modal-body
            console.log("Hiding new-modal-body");
        }
    });
}




 // Get JSON data from PHP
 const allData = <?php echo $jsonData; ?>;

// Function to filter data based on selected year
function filterData() {
    const selectedYear = document.getElementById('year').value;
    const filteredData = selectedYear === 'All' 
        ? allData 
        : allData.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody = document.getElementById('data-table').querySelector('tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    if (filteredData.length > 0) {
        filteredData.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData();
</script>



<script>

// Get JSON data from PHP
const allData2 = <?php echo $jsonData2; ?>;

// Function to filter data based on selected year
function filterData2() {
    const selectedYear = document.getElementById('year2').value;
    const filteredData2 = selectedYear === 'All' 
        ? allData2 
        : allData2.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody2 = document.getElementById('data-table2').querySelector('tbody');
    tableBody2.innerHTML = ''; // Clear existing rows

    if (filteredData2.length > 0) {
        filteredData2.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody2.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody2.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData2();

</script>


<script>

// Get JSON data from PHP
const allData3 = <?php echo $jsonData3; ?>;

// Function to filter data based on selected year
function filterData3() {
    const selectedYear = document.getElementById('year3').value;
    const filteredData3 = selectedYear === 'All' 
        ? allData3 
        : allData3.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody3 = document.getElementById('data-table3').querySelector('tbody');
    tableBody3.innerHTML = ''; // Clear existing rows

    if (filteredData3.length > 0) {
        filteredData3.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody3.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody3.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData3();

</script>

<script>

// Get JSON data from PHP
const allData4 = <?php echo $jsonData4; ?>;

// Function to filter data based on selected year
function filterData4() {
    const selectedYear = document.getElementById('year4').value;
    const filteredData4 = selectedYear === 'All' 
        ? allData4 
        : allData4.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody4 = document.getElementById('data-table4').querySelector('tbody');
    tableBody4.innerHTML = ''; // Clear existing rows

    if (filteredData4.length > 0) {
        filteredData4.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody4.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody4.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData4();

</script>



<script>

// Get JSON data from PHP
const allData5 = <?php echo $jsonData5; ?>;

// Function to filter data based on selected year
function filterData5() {
    const selectedYear = document.getElementById('year5').value;
    const filteredData5 = selectedYear === 'All' 
        ? allData5 
        : allData5.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody5 = document.getElementById('data-table5').querySelector('tbody');
    tableBody5.innerHTML = ''; // Clear existing rows

    if (filteredData5.length > 0) {
        filteredData5.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody5.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody5.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData5();

</script>



<script>

// Get JSON data from PHP
const allData6 = <?php echo $jsonData6; ?>;

// Function to filter data based on selected year
function filterData6() {
    const selectedYear = document.getElementById('year6').value;
    const filteredData6 = selectedYear === 'All' 
        ? allData6 
        : allData6.filter(row => row.year === selectedYear);

    // Update table with filtered data

    //Stn XIII
    const tableBody6 = document.getElementById('data-table6').querySelector('tbody');
    tableBody6.innerHTML = ''; // Clear existing rows

    if (filteredData6.length > 0) {
        filteredData6.forEach(data => {
            const row = `<tr>
                <td>${data['phytoplankton count']}</td>
                <td>${data.year}</td>
                <td>${data.station}</td>
                <td>${data.months}</td>
            </tr>`;
            tableBody6.insertAdjacentHTML('beforeend', row);
        });
    } else {
        // Display message if no data is available
        tableBody6.innerHTML = '<tr><td colspan="4">No data available for this month and selected year</td></tr>';
    }

   
}



// Initialize table with all data on page load
filterData6();

</script>




    <script>
        // Initialize chart index
        let currentChartIndex = 0;
        const charts = [
            document.getElementById("temperatureChartContainer"),
            document.getElementById("humidityChartContainer"),
            document.getElementById("windChartContainer"),

        ];

        // Function to show the current chart based on the index
        function showChart(index) {
            // Ensure only the active chart is visible
            charts.forEach((chart, i) => {
                chart.classList.toggle('active', i === index);
                console.log(`Chart at index ${i} is ${chart.classList.contains('active') ? 'active' : 'inactive'}`);
            });
        }

        // Function to show the next chart
        function nextChart() {
            charts[currentChartIndex].classList.remove('active');
            currentChartIndex = (currentChartIndex + 1) % charts.length;
            showChart(currentChartIndex);
            console.log(`Showing chart index: ${currentChartIndex}`); // Debugging line
        }

        // Function to show the previous chart
        function prevChart() {
            charts[currentChartIndex].classList.remove('active');
            currentChartIndex = (currentChartIndex - 1 + charts.length) % charts.length;
            showChart(currentChartIndex);
            console.log(`Showing chart index: ${currentChartIndex}`); // Debugging line
        }

        // Show the first chart initially
        showChart(currentChartIndex);

        // Optional: Automatically slide charts every few seconds
        let slideInterval = setInterval(nextChart, 10000);

        // Pause the sliding when the mouse enters any chart container
        charts.forEach(chart => {
            chart.addEventListener('mouseenter', () => clearInterval(slideInterval));
            chart.addEventListener('mouseleave', () => {
                slideInterval = setInterval(nextChart, 10000);
            });
        });


        // Temperature Chart
        const tempCtx = document.getElementById("temperatureChart").getContext("2d");
        new Chart(tempCtx, {
            type: "line",
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Max Temperature (°C)",
                        data: temperatureMax,
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: "Min Temperature (°C)",
                        data: temperatureMin,
                        borderColor: "rgba(54, 162, 235, 1)",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Temperature (°C)"
                        }
                    }
                }
            }
        });

        // Humidity Chart
        const humidityCtx = document.getElementById("humidityChart").getContext("2d");
        new Chart(humidityCtx, {
            type: "line",
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Max Humidity (%)",
                        data: humidityMax,
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        label: "Min Humidity (%)",
                        data: humidityMin,
                        borderColor: "rgba(153, 102, 255, 1)",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Humidity (%)"
                        }
                    }
                }
            }
        });

        // Wind Speed Chart
        const windCtx = document.getElementById("windChart").getContext("2d");
        new Chart(windCtx, {
            type: "line",
            data: {
                labels: dates,
                datasets: [
                    {
                        label: "Max Wind Speed (m/s)",
                        data: windSpeedMax,
                        borderColor: "rgba(255, 206, 86, 1)",
                        borderWidth: 2,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Wind Speed (m/s)"
                        }
                    }
                }
            }
        });

       
    </script>

<!--time series graph -->
<script>
        $(document).ready(function() {
            // Automatically load the content of 'otherpage.php' when the page loads
            $("#TimeChart").load("Time.php");
        });
    </script>


</body>

</html>