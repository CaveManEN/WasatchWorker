<?php
// Collect the form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Unknown'; // Collect the name field
$phone_number = isset($_POST['phone-number']) ? htmlspecialchars($_POST['phone-number']) : 'Unknown';
$pickup_date = isset($_POST['pickup-date']) ? htmlspecialchars($_POST['pickup-date']) : 'Unknown';
$pickup_time = isset($_POST['pickup-time']) ? htmlspecialchars($_POST['pickup-time']) : 'Unknown';
$equipment_type = isset($_POST['equipment-type']) ? htmlspecialchars($_POST['equipment-type']) : 'Unknown';
$service_type = isset($_POST['service-type']) ? htmlspecialchars($_POST['service-type']) : 'Unknown';
$pickup_address = isset($_POST['pickup-address']) ? htmlspecialchars($_POST['pickup-address']) : 'Unknown'; // Pick-up Address
$num_skis_snowboards = isset($_POST['num-skis-snowboards']) ? htmlspecialchars($_POST['num-skis-snowboards']) : 'Unknown'; // Number of Skis/Snowboards

// Create the message to send to Telegram
$message = "New Booking Received:\n";
$message .= "Name: $name\n"; // Add the Name field to the message
$message .= "Phone Number: $phone_number\n";
$message .= "Pick-up Date: $pickup_date\n";
$message .= "Pick-up Time: $pickup_time\n";
$message .= "Pick-up Address: $pickup_address\n"; // Add the Pick-up Address to the message
$message .= "Number of Skis/Snowboards: $num_skis_snowboards\n"; // Add the Number of Skis/Snowboards to the message
$message .= "Equipment Type: $equipment_type\n";
$message .= "Service Type: $service_type\n";

// Your Telegram bot token
$botToken = '7512992618:AAFagG7MP2jSosZCWwCLgMmmZxIByDMagKk';
// Array of chat IDs
$chatIds = ['6190145582', '7752964476']; 
// Telegram API URL
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";

// Loop through each chat ID to send the message
foreach ($chatIds as $chatId) {
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
        if (!$responseData['ok']) {
            // If Telegram API responded with an error
            echo "Error: Telegram API returned an error: " . $responseData['description'];
        }
    }

    // Close cURL session for this chat ID
    curl_close($ch);
}

// Redirect to the thank-you page after sending to all chat IDs
header("Location: thank-you.html");
exit;
?>
