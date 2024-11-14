<?php

session_start();
$_SESSION["Username"];
$_SESSION["Email"];

if (!isset($_SESSION['Username']) || empty($_SESSION['Username'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit(); // Exit to ensure no further code is executed after the redirect
}

$_SESSION["date"] = isset($_SESSION["date"]) ? $_SESSION["date"] : date('Y-m-d'); // Ensure session date is initialized

# Weather API
$latitude = "14.5243"; // Latitude for Taguig
$longitude = "121.0792"; // Longitude for Taguig
$timezone = "Asia/Singapore"; // Timezone for Taguig

// API URL for 7-Day Forecast including humidity
$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=weather_code,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,relative_humidity_2m_min,wind_speed_10m_max,wind_direction_10m_dominant&timezone={$timezone}";

// Fetch weather data from the API
$weatherData = @file_get_contents($apiUrl);

if ($weatherData === FALSE) {
    echo "Error fetching weather data. Please check the URL.";
    exit;
}

$weatherArray = json_decode($weatherData, true);

if (isset($weatherArray['daily'])) {
    $dailyData = $weatherArray['daily'];
    $dates = $dailyData['time'];
    $temperatureMax = $dailyData['temperature_2m_max'];
    $temperatureMin = $dailyData['temperature_2m_min'];
    $humidityMax = $dailyData['relative_humidity_2m_max'];
    $humidityMin = $dailyData['relative_humidity_2m_min'];
    $windSpeedMax = $dailyData['wind_speed_10m_max'];
    $windDirectionDominant = $dailyData['wind_direction_10m_dominant'];
    $weatherCode = $dailyData['weather_code'];

    // Default to show tomorrow's data
    if (isset($_GET['date']) && in_array($_GET['date'], $dates)) {
        $selectedDate = $_GET['date'];
        $_SESSION["date"] = $selectedDate;
    } else {
        $selectedDate = $_SESSION["date"];
    }


    // Find index for the selected date
    $index = array_search($selectedDate, $dates);

    if ($index !== false) {
    /*
    echo "
    <div class='position-absolute bottom-0 end-0 m-3 p-3 border border-success rounded shadow' style='width: 550px;'>
        <h5 class='text-center text-dark mb-3'>Weather Forecast for {$selectedDate}</h5>
        <table class='table table-bordered'>
            <thead class='table-success'>
                <tr>
                    <th>Weather Code</th>
                    <th>Max Temp (°C)</th>
                    <th>Min Temp (°C)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{$weatherCode[$index]}</td>
                    <td>{$temperatureMax[$index]}</td>
                    <td>{$temperatureMin[$index]}</td>
                </tr>
                <tr>
                    <th>Max Humidity (%)</th>
                    <th>Min Humidity (%)</th>
                    <th>Max Wind (m/s)</th>
                </tr>
                <tr>
                    <td>{$humidityMax[$index]}</td>
                    <td>{$humidityMin[$index]}</td>
                    <td>{$windSpeedMax[$index]}</td>
                </tr>
            </tbody>
        </table>
    </div>
    ";
    */
} else {
    echo "
    <div class='position-fixed bottom-0 end-0 m-3 p-3 bg-light border border-danger rounded shadow'>
        <p class='text-danger text-center mb-0'>Data for the selected date is not available.</p>
    </div>
    ";
}
    
} else {
    echo "Unable to fetch weather data.";
}

// Handle Flask API request and response
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $results = [];

    $data = [
        'Temperature' => [floatval($temperatureMax[$index])],
        'Humidity' => [floatval($humidityMax[$index])],
        'Wind Speed' => [floatval($windSpeedMax[$index])],
        'Date' => $_SESSION["date"],
    ];

    $json_data = json_encode($data);

    $url = 'http://127.0.0.1:5000/predict_and_learn';  // Flask API URL
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response from the Flask API
    $response = json_decode($result, true);

    if (isset($response['status']) && $response['status'] == 'Error') {
        $error_message = $response['message'];
        $results['error_message'] = $error_message;
    } else {
        $results['status'] = $response['status'];
        $results['predictions'] = $response['results'];
    }
}

$phyto = [];

if (isset($results)) {
    if (isset($results['error_message'])) {
        echo "Error: " . $results['error_message'] . "\n";
    } else {
        foreach ($results['predictions'] as $station_name => $result) {
            #echo "Results for " . $station_name . "\n";
            #echo "Predicted Phytoplankton Count (cells/ml): " . $result['prediction'][0] . "\n";
            $phyto[$station_name] = $result['prediction'][0]; // Store predictions by station name
            #echo "Forecast:\n";
            foreach ($result['forecast'] as $key => $value) {
                #echo $key . ": " . $value . "\n";
            }
        }
    }
} else {
    
}



    #Modal Table
    $csvFile = 'C:/Users/' . getenv('USERNAME') . '/Desktop/Datamodel/Complete_MICE_Imputed.csv';
    
    $csvData = array_map('str_getcsv', file($csvFile));
    $header = $csvData[0];
    unset($csvData[0]); // Remove the header row for data processing
    
    // Define the current month
    $currentMonth = date('m');
    
    // Array to store unique years for the dropdown
    $years = [];
    
    // Loop through the data to get unique years
    foreach ($csvData as $row) {
        $row = array_combine($header, $row);
        $years[] = $row['Year'];
    }
    $years = array_unique($years); // Remove duplicate years
    sort($years); // Sort years in ascending order
    
    // Get the selected year from the form (default to "All")
    $selectedYear = isset($_POST['year']) ? $_POST['year'] : 'All';
    
    // Array to store the filtered data
    $filteredData = [];
    $filteredData2 = [];
    $filteredData3 = [];
    $filteredData4 = [];
    $filteredData5 = [];
    $filteredData6 = [];
    
    

?>