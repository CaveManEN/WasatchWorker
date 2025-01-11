<?php
// Collect the form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : 'Unknown';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'Unknown';
$phone_number = isset($_POST['phone-number']) ? htmlspecialchars($_POST['phone-number']) : 'Unknown';
$message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : 'No message provided';

// Create the message to send to Telegram
$telegramMessage = "New Contact Message Received:\n";
$telegramMessage .= "Name: $name\n";
$telegramMessage .= "Email: $email\n";
$telegramMessage .= "Phone Number: $phone_number\n"; // Add the phone number
$telegramMessage .= "Message: $message";

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
        'text' => $telegramMessage
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

// Redirect to the thank-you page
header("Location: contactthanks.html");
exit;
?>

