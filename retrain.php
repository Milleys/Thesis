<?php
session_start();
include 'backend/db_connect.php';
$_SESSION["Username"];
$_SESSION["Email"];
#FLASK
if (isset($_POST['submit_flask'])) {

    $data = [
        'Temperature' => [floatval($_POST['temperature'])],
        'Humidity' => [floatval($_POST['humidity'])],
        'Wind Speed' => [floatval($_POST['wind_speed'])],
        'pH (units)' => [floatval($_POST['ph'])],
        'Ammonia (mg/L)' => [floatval($_POST['ammonia'])],
        'Inorganic Phosphate (mg/L)' => [floatval($_POST['phosphate'])],
        'BOD (mg/l)' => [floatval($_POST['bod'])],
        'Total coliforms (MPN/100ml)' => [floatval($_POST['coliforms'])]
    ];

    $json_data = json_encode($data);

    $url = 'http://127.0.0.1:5000/model_testing';  // Flask API URL
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    curl_close($ch);

    // Decode the JSON response from the Flask API
    $response = json_decode($result, true);
    $prediction = $response['prediction'][0];
    $status = $response['status'];
    $rounded = round($prediction);



}


// Check if the form has been submitted
if (isset($_POST["Retrain"])) {
    // Check if a dataset has been selected
    if (!empty($_POST['selected_dataset'])) {
        // Get the selected dataset value (e.g., dataset filename)
        $selectedDataset = $_POST['selected_dataset'];
        
        // Encode the dataset name to JSON
        $json_data = json_encode(['dataset' => $selectedDataset]);
    
        // Send the selected dataset to the Flask API
        $url = 'http://127.0.0.1:5000/retrain_model';  // Flask API URL
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $result = curl_exec($ch);
        curl_close($ch);
    
        // Decode the JSON response from the Flask API
        $response = json_decode($result, true);
        
        if (isset($response['mse']) && isset($response['mae']) && isset($response['r2'])) {
            // Display the metrics returned from Flask
            $mse = $response['mse'];
            $mae = $response['mae'];
            $r2 = $response['r2'];
            $dh = $response['dh'];
            $dd = $response['dd'];
            $dm = $response['dm'];
            $total_rows = $response['total_rows'];
            $total_columns = $response['total_columns'];
            
        } else {
            echo "<script type='text/javascript'>alert('". htmlspecialchars($response['error']) ."');</script>";
        }
    } else {
        echo "<p>No dataset selected.</p>";
    }
}




if (isset($_POST["Train"])) {
    // Check if a dataset has been selected
    if (!empty($_POST['selected_dataset'])) {
        // Get the selected dataset value (e.g., dataset filename)
        $selectedDataset = $_POST['selected_dataset'];
        
        // Encode the dataset name to JSON
        $json_data = json_encode(['dataset' => $selectedDataset]);
    
        // Send the selected dataset to the Flask API
        $url = 'http://127.0.0.1:5000/export_model';  // Flask API URL
        $ch = curl_init($url);
    
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $result = curl_exec($ch);
        curl_close($ch);
    
        // Decode the JSON response from the Flask API
        $response = json_decode($result, true);
        
        if (isset($response['update'])) {
            // Display the metrics returned from Flask
            $mse = $response['update'];

            $message = "Retrained New Model using ".$selectedDataset." ";
            $user = $_SESSION['Username'];
            $email = $_SESSION['Email'];
            $sql2 = "INSERT INTO history (Action_User, Action_Email, Action) VALUES ('$user','$email','$message')";
            $conn->query($sql2);

            echo "<script type='text/javascript'>alert('Model Exported Successfully');</script>";


            
        } else {
            echo "<script type='text/javascript'>alert('". htmlspecialchars($response['error']) ."');</script>";
        }
    } else {
        echo "<script type='text/javascript'>alert('No Dataset Selected');</script>";
    }
}


?>