<?php
session_start();
ob_start();
header('Content-type: application/json');
date_default_timezone_get('UTC');

// connect to DB
//echo '<p>connecting to db</p>';
$db = new mysqli('localhost', 'chat', 'chat', 'chat');
if(mysqli_connect_errno()){
    die('<p>Error: Could not connect to database.<br />Please try again later.</p>');
}

try{
    $curTime = time();
    $ssid = session_id();
    $lastPoll = isset($_SESSION['last_poll']) ? $_SESSION['last_poll'] : $curTime;
    $action = (isset($_SERVER['REQUEST_METHOD']) && ($_SERVER['REQUEST_METHOD'] == 'POST')) ? 'send' : 'poll';
    //echo '<p>curTime='.$curTime.'</p>';
    //echo '<p>ssid='.$ssid.'</p>';
    //echo '<p>lastPoll='.$lastPoll.'</p>';
    //echo '<p>action='.$action.'</p>';
    switch($action){
        case 'poll':
            $query = "SELECT * FROM chatlog WHERE date_created >= ?";
            //echo '<p>query='.$query.'</p>';
            $stmt = $db->prepare($query);
            $stmt->bind_param('i', $lastPoll);
            $stmt->execute();
            $stmt->bind_result($id, $message, $ssid, $date_created);
            $result = $stmt->get_result();

            $newChats = [];
            while($chat = $result->fetch_assoc()){
                if($ssid == $chat['sent_by']){
                    $chat['sent_by'] = 'self';
                }else{
                    $chat['sent_by'] = 'other';
                }
                $newChats[] = $chat;
            }

            $_SESSION['last_poll'] = $curTime;

            print json_encode([
                'success' => true,
                'messages' => $newChats
            ]);

            exit;

        case 'send':
            $message = isset($_POST['message']) ? $_POST['message'] : '';
            $message = strip_tags($message);

            $query = "INSERT INTO chatlog (message, sent_by, date_created) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssi", $message, $ssid, $curTime);
            $stmt->execute();

            print json_encode([
                'success' => true,
                'message' => $message
            ]);
            exit;
    }
}catch(Exception $e){
    print json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}