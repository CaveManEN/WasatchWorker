<?php
// Collect the form data
$name = $_POST['name']; // Collect the name field
$phone_number = $_POST['phone-number'];
$pickup_date = $_POST['pickup-date'];
$pickup_time = $_POST['pickup-time'];
$equipment_type = $_POST['equipment-type'];
$service_type = $_POST['service-type'];

// Create the message to send to Telegram
$message = "New Booking Received:\n";
$message .= "Name: $name\n"; // Add the Name field to the message
$message .= "Phone Number: $phone_number\n";
$message .= "Pick-up Date: $pickup_date\n";
$message .= "Pick-up Time: $pickup_time\n";
$message .= "Equipment Type: $equipment_type\n";
$message .= "Service Type: $service_type\n";

// Your Telegram bot token and chat ID
$botToken = '7512992618:AAFagG7MP2jSosZCWwCLgMmmZxIByDMagKk';
$chatId = '6190145582'; // Use the chat ID you retrieved

// Telegram API URL
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";

// Data to send
$data = [
    'chat_id' => $chatId,
    'text' => $message
];

// Initialize cURL session
$ch = curl_init($telegramUrl);

// Set the cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Execute the request and get the response
$response = curl_exec($ch);

// Check if cURL execution was successful
if ($response === false) {
    // Output cURL error if the request fails
    echo "Error: cURL failed with error: " . curl_error($ch);
} else {
    // Decode the response to check for Telegram API success
    $responseData = json_decode($response, true);
    if ($responseData['ok']) {
        // If success, redirect to the thank-you page
        header("Location: thank-you.html");
        exit;
    } else {
        // If Telegram API responded with an error
        echo "Error: Telegram API returned an error: " . $responseData['description'];
    }
}

// Close cURL session
curl_close($ch);
?>


