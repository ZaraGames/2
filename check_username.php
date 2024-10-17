<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function check_username($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    
    // Execute cURL request
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ['error' => true, 'message' => $error_msg];
    }

    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // If the HTTP response code is 404, the username does not exist
    return $response_code === 404;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Output the received POST data for debugging
    echo json_encode([
        'received' => true,
        'username' => $_POST['username']
    ]);
    exit;
}
//2
    
    // Check on different platforms
    $platforms = [
        'YouTube' => 'https://www.youtube.com/' . $username,
        'Facebook' => 'https://www.facebook.com/' . $username,
        'Instagram' => 'https://www.instagram.com/' . $username,
        'Twitter' => 'https://twitter.com/' . $username,
        'Twitch' => 'https://www.twitch.tv/' . $username,
        'TikTok' => 'https://www.tiktok.com/@' . $username,
        'Snapchat' => 'https://www.snapchat.com/add/' . $username,
        'Reddit' => 'https://www.reddit.com/user/' . $username,
        'Pinterest' => 'https://www.pinterest.com/' . $username,
        'GitHub' => 'https://github.com/' . $username,
        'About.me' => 'https://about.me/' . $username,
        'Medium' => 'https://medium.com/@' . $username,
        'Behance' => 'https://www.behance.net/' . $username,
        'VK' => 'https://vk.com/' . $username,
        'Spotify' => 'https://open.spotify.com/user/' . $username,
        'Telegram' => 'https://t.me/' . $username
    ];

    foreach ($platforms as $platform => $url) {
        $result = check_username($url);

        // Handle cURL error responses
        if (isset($result['error']) && $result['error']) {
            $results[$platform] = 'Error: ' . $result['message'];
        } else {
            $results[$platform] = $result ? 'Available' : 'Taken';
        }
    }

    header('Content-Type: application/json');
    echo json_encode($results);
}

