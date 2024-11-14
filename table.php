<?php
// Load the CSV file
$csvFile = 'C:\Users\John Wilson\Desktop\Datamodel\Complete_MICE_Imputed.csv';
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

// Loop through the data and filter rows based on month, year, and specific station
foreach ($csvData as $row) {
    $row = array_combine($header, $row);

    // Filter by current month and specific station
    // If "All" is selected, skip the year filter
    if ($row['Month'] === $currentMonth && $row['Monitoring Stations'] === 'Stn. I (Central West Bay)') {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Phytoplankton Count for Station V</title>
</head>
<body>

<h2>Phytoplankton Count for Station V (<?php echo date('F'); ?>)</h2>

<!-- Year selection form -->
<form method="POST">
    <label for="year">Select Year:</label>
    <select name="year" id="year" onchange="this.form.submit()">
        <option value="All" <?php if ($selectedYear === 'All') echo 'selected'; ?>>All</option>
        <?php foreach ($years as $year): ?>
            <option value="<?php echo $year; ?>" <?php if ($year == $selectedYear) echo 'selected'; ?>>
                <?php echo $year; ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<!-- Display the filtered data in a table -->


<table border="1">
    <thead>
        <tr>
            <th>Phytoplankton Count</th>
            <th>Year</th>
            <th>Station</th>
            <th>Month</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($filteredData)): ?>
            <?php foreach ($filteredData as $data): ?>
                <tr>
                    <td><?php echo htmlspecialchars($data['phytoplankton count']); ?></td>
                    <td><?php echo htmlspecialchars($data['year']); ?></td>
                    <td><?php echo htmlspecialchars($data['station']); ?></td>
                    <td><?php echo htmlspecialchars($data['months']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No data available for this month and selected year</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>






