<?php
header('Content-Type: application/json');

$endpoint = 'https://api.github.com';
$user = isset($_GET['user']) ? $_GET['user'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$followersPerPage = 30;

if (empty($user)) {
    echo json_encode(['error' => 'No user specified.']);
    exit;
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');

if (isset($_GET['action']) && $_GET['action'] === 'getFollowers') {

    // Retrieve follower list
    $url = "{$endpoint}/users/{$user}/followers?per_page={$followersPerPage}&page={$page}";
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);

    echo $response;

} else {

    // Retrieve user info

    $url = "{$endpoint}/users/{$user}";
    curl_setopt($ch, CURLOPT_URL, $url);
    $response = curl_exec($ch);

    $userInfo = json_decode($response, true);

    if (isset($userInfo['login'])) {
        echo json_encode($userInfo);
    } else {
        echo json_encode(['error' => 'User not found.']);
    }
}

curl_close($ch);
?>
