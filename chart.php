<?php
$_SESSION["date"] = isset($_SESSION["date"]) ? $_SESSION["date"] : date('Y-m-d'); // Ensure session date is initialized

# Weather API
$latitude = "14.5243"; // Latitude for Taguig
$longitude = "121.0792"; // Longitude for Taguig
$timezone = "Asia/Singapore"; // Timezone for Taguig

// API URL for 7-Day Forecast including humidity
$apiUrl = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&daily=weather_code,temperature_2m_max,temperature_2m_min,relative_humidity_2m_max,relative_humidity_2m_min,wind_speed_10m_max,wind_direction_10m_dominant&timezone={$timezone}";

// Fetch weather data from the API
$weatherData = @file_get_contents($apiUrl);

// Decode the JSON data
$weatherArray = json_decode($weatherData, true);

// Extract daily data
$dailyData = $weatherArray['daily'];
$dates = $dailyData['time'];
$temperatureMax = $dailyData['temperature_2m_max'];
$temperatureMin = $dailyData['temperature_2m_min'];
$humidityMax = $dailyData['relative_humidity_2m_max'];
$humidityMin = $dailyData['relative_humidity_2m_min'];
$windSpeedMax = $dailyData['wind_speed_10m_max'];



// Correctly parse and format dates from the dataset
$formattedDates = array_map(function ($date) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    return $dateTime ? $dateTime->format('M j, Y') : $date;
}, $dates);
?>

<script>
    // Pass PHP data to JavaScript
    const dates = <?php echo json_encode($formattedDates); ?>;
    const temperatureMax = <?php echo json_encode($temperatureMax); ?>;
    const temperatureMin = <?php echo json_encode($temperatureMin); ?>;
    const humidityMax = <?php echo json_encode($humidityMax); ?>;
    const humidityMin = <?php echo json_encode($humidityMin); ?>;
    const windSpeedMax = <?php echo json_encode($windSpeedMax); ?>;
   
</script>


