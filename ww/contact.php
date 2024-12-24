<?php
// Collect the form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Create the message to send to Telegram
$telegramMessage = "New Contact Message Received:\n";
$telegramMessage .= "Name: $name\n";
$telegramMessage .= "Email: $email\n";
$telegramMessage .= "Message: $message";

// Your Telegram bot token and chat ID
$botToken = '7512992618:AAFagG7MP2jSosZCWwCLgMmmZxIByDMagKk';
$chatId = '6190145582'; // Use the chat ID you retrieved

// Telegram API URL
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";

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
    if ($responseData['ok']) {
        // If success, redirect to the thank-you page
        header("Location: contactthanks.html");
        exit;
    } else {
        // If Telegram API responded with an error
        echo "Error: Telegram API returned an error: " . $responseData['description'];
    }
}

// Close cURL session
curl_close($ch);

header("Location: contactthanks.html");
exit;

?>
