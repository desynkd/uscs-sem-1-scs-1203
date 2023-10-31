<?php

ini_set('session.use_only_cookie', 1);
ini_set('session.use_strict_mode', 1);

session_set_cookie_params([
    'lifetime' => 1800,
    'domain' => 'localhost',
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

if (isset($_SESSION["user_id"])) {
    // Regenerate the session ID when a user is logged in
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id_loggedin();
    } else {
        // Check if it's time to regenerate the session ID for security
        $interval = 60 * 30;
        if(time() - $_SESSION["last_regeneration"] >= $interval){
            regenerate_session_id_loggedin();
        }
    }

} else {
    // Regenerate the session ID every 30 seconds 
    //for security when the user is not logged in
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        // Check if it's time to regenerate the session ID for security
        $interval = 60 * 30;
        if(time() - $_SESSION["last_regeneration"] >= $interval){
            regenerate_session_id();
        }
    }
}

function regenerate_session_id_loggedin() {
    // Regenerate the session ID and update the last regeneration time
    session_regenerate_id(true);

    $userId = $_SESSION["user_id"];
    $newSessionId = session_create_id();
    $sessionId = $newSessionId . " " . $userId;
    session_id($sessionId);

    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id() {
    // Regenerate the session ID and update the last 
    //regeneration time when the user is logged in
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
}