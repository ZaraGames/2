<?php

function check_username($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_exec($ch);

    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // If the HTTP response code is 404, the username does not exist
    return $response_code === 404;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $results = [];

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
        $results[$platform] = check_username($url);
    }

    header('Content-Type: application/json');
    echo json_encode($results);
}
