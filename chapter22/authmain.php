<?php

session_start();

if(isset($_POST['userid']) && isset($_POST['password'])){
    // if the user has just tried to log in
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    $db = new mysqli('localhost', 'webauth', 'webauth', 'auth');
    if(mysqli_connect_errno()){
        die('Connection to database failed: '.mysqli_connect_errno());
    }

    $query = "select * from authorized_users where name='".$userid."' and password=sha1('".$password."')";
    $result = $db->query($query);
    if($result->num_rows){
        // if they are in the database register the user id
        $_SESSION['valid_user'] = $userid;
    }
    $db->close();
}

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <style type='text/css'>
            fieldset {
                width: 50%;
                border: 2px solid $ff0000;
            }
            legend {
                font-weight: bold;
                font-size: 125%;
            }
            label {
                width: 125%;
                float: left;
                text-align: left;
                font-weight: bold;
            }
            input {
                border: 1px solid $000;
                padding: 3px;
            }
            button {
                margin-top: 12px;
            }
         </style>
    </head>
    <body>
        <h1>Home Page</h1>
        <?php
            if(isset($_SESSION['valid_user'])){
                echo '<p>You are logged in as: '.$_SESSION['valid_user'].'<br />';
                echo '<a href="logout.php">Log out</a></p>';
            }else{
                if(isset($userid)){
                    // if they've tried and failed to login
                    echo '<p>Could not log you in.</p>';
                }else{
                    // they have not tried to login yet or have logged out
                    echo '<p>You are not logged in.</p>';
                }

                // provide form to login
        ?>
                
                <form action='authmain.php' method='post'>
                    <fieldset>
                        <legend>Login Now!</legend>
                        <p>
                            <label for='userid'>UserID:</label>
                            <input type='text' name='userid' id='userid' size='30' />
                        </p>
                        <p>
                            <label for='password'>Password:</label>
                            <input type='password' name='password' id='password' size='30' />
                        </p>
                    </fieldset>
                    <button type='submit' name='login'>Login</button>
                </form>
                
        <?php
            }
        ?>

        <p><a href='members_only.php'>Go to Members Section</a></p>
        
    </body>
</html>