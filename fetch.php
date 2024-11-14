<?php
header('Content-Type: application/json');

// Path to your CSV file (Make sure this path is correct for your system)
$csvFile = 'C:/Users/' . getenv('USERNAME') . '/Desktop/Datamodel/MICE_Time.csv'; 

$csvData = [];
if (($handle = fopen($csvFile, 'r')) !== false) {
    // Get headers
    $header = fgetcsv($handle);

    // Loop through each row of the CSV
    while (($row = fgetcsv($handle)) !== false) {
        // Combine header and row into an associative array
        $csvData[] = array_combine($header, $row);
    }
    fclose($handle);
}

// Ensure dates are in proper format for JavaScript to read
foreach ($csvData as &$row) {
    // Convert 'Date' field from DD/MM/YYYY to YYYY-MM-DD (ISO format)
    $date = DateTime::createFromFormat('d/m/Y', $row['Date']);
    if ($date) {
        $row['Date'] = $date->format('Y-m-d'); // Convert to ISO format
    }
}

// Send the CSV data as JSON to the frontend
echo json_encode($csvData);
?>
