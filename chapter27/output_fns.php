<?php
function do_html_header($title){
    // print an HTML header
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title><?php echo $title;?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <style>
                body {
                    font-family: Arial, Helvetica, sans-serif; 
                    font-size: 13px;
                }

                li, td {
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 13px;
                }

                hr {
                    color: #3333cc;
                }

                a {
                    color: #000;
                }

                div.formblock {
                    background: #ccc;
                    width: 300px;
                    padding: 6px;
                    border: 1px solid #000;
                }
            </style>
        </head>
        <body>
            <div>
                <img src="bookmark.jpg" alt="PHPbookmark logo" height="55" width="57" style="float: left; padding-right: 6px;" />
                <h1>PHPbookmark</h1>
            </div>
            <hr />
    ';

    if($title){
        do_html_heading($title);
    }
}

function do_html_footer(){
    // print an HTML footer
    echo '</body></html>';
}

function do_html_heading($heading){
    // print heading
    echo '<h2>'.$heading.'</h2>';
}

function do_html_url($url, $name){
    echo '<br><a href="'.$url.'">'.$name.'</a><br>';
}

function display_site_info(){
    // display some marketing info
    echo '
        <ul>
            <li>Store your bookmarks online with us!</li>
            <li>See what other uers user!</li>
            <li>Share your favorite links with others!</li>
        </ul>
    ';
}

function display_login_form(){
    echo '
        <p><a href="register_form.php">Not a member?</a></p>
        <form method="post" action="member.php">
            <div class="formblock">
                <h2>Members Login Here</h2>
                
                <p>
                    <label for="username">UserName:</label><br />>
                    <input type="text" name="username" id="username" />
                </p>

                <p>
                    <label for="passwd">Password:</label><br />
                    <input type="password" name="passwd" id="passwd" />
                </p>

                <button type="submit">Login</button>

                <p><a href="forgot_form.php">Forgot your password?</a></p>
            </div>
        </form>
    ';
}

function display_registration_form(){
    echo '
        <form method="post" action="register_new.php">
            <div class="formblock">
                <h2>Register Now!</h2>

                <p>
                    <label for="email">Email Address:</label><br/>
                    <input type="email" name="email" id="email" size="30" maxlength="100" required />
                </p>

                <p>
                    <label for="username">Preferred Username<br>(max 16 chars):</label><br/>
                    <input type="text" name="username" id="username" size="16" maxlength="16" required />
                </p>

                <p>
                    <label for="passwd">Password<br>(between 6 and 16 chars):</label><br/>
                    <input type="password" name="passwd" id="passwd" size="16" maxlength="16" required />
                </p>

                <p>
                    <label for="passwd2">Confirm Password:</label><br/>
                    <input type="password" name="passwd2" id="passwd2" size="16" maxlength="16" required />
                </p>

                <button type="submit">Register</button>
            </div>
        </form>
    ';
}

function display_user_urls($url_array){
    // display the table of urls

    // set global variable, so we can test later if this is on the page
    global $bm_table;
    $bm_table = true;
?>

    <br>
    <form name="bm_table" action="delete_bms.php" method="post">
        <table width="300" cellpadding="2" cellspacing="0" >
            <?php
                $color = "#cccccc";
                echo "<tr bgcolor=\"".$color."\"><td><strong>Bookmarks</strong></td><td><strong>Delte?</strong></td></tr>";
                if (is_array($url_array) && (count($url_array) > 0)){
                    foreach($url_array as $url){
                        if($color == "#cccccc"){
                            $color = "#ffffff";
                        }else{
                            $color = "#cccccc";
                        }

                        // remember to call htmlspecialchars() when we are displaying user data
                        echo "<tr bgcolor=\"".$color."\">
                            <td><a href=\"".$url."\">".htmlspecialchars($url)."</a></td>
                            <td><input type=\"checkbox\" name=\"del_me[]\" value=\"".$url."\"</td>
                            </tr>";
                    }
                }else{
                    echo "<tr><td>No bookmarks on records!</td></tr>";
                }
            ?>
        </table>
    </form>

<?php
}

function display_user_menu(){
    // display the menu options on this page
?>

    <hr>
    <a href="member.php">Home</a>&nbsp;|&nbsp;
    <a href="add_bm_form.php">Add BM</a>&nbsp;|&nbsp;

<?php
    // only offer the delete option if bookmark table is on this page
    global $bm_table;
    if($bm_table == true){
        echo '
            <a href="#" onClick="bm_table.submit();">Delete BM</a>&nbsp;|&nbsp;
        ';
    }else {
        echo '
            <span style="color: #cccccc">Delete BM</span>&nbsp;|&nbsp;
        ';
    }

?>

<a href="change_passwd_form.php">Change Password</a><br/>
<a href="recommend.php">Recommend URLs to me</a>&nbsp;|&nbsp;
<a href="logout.php">Logout</a>
<hr>

<?php
}

function display_add_bm_form(){
    // display the form for people to enter a new bookmark in
?>

    <form name="bm_table" action="add_bms.php" method="post">
        <div class="formblock">
            <h2>New Bookmark</h2>
            <p>
                <input type="text" name="new_url" id="new_url" size="40" maxlength="255" value="http://" required />
            </p>

            <button type="submit">Add Bookmark</button>
        </div>
    </form>

<?php
}

function display_password_form(){
    // display html change password form
?>

    <br>
    <form action="change_passwd.php" method="post">
        <div class="formblock">
            <h2>Change Password</h2>
            <p>
                <label for="old_passwd">Old Password:</label><br/>
                <input type="password" name="old_passwd" id="old_passwd" size="16" maxlength="16" required />
            </p>
            <p>
                <label for="new_passwd">New Password:</label><br/>
                <input type="password" name="new_passwd" id="new_passwd" size="16" maxlength="16" required />
            </p>
            <p>
                <label for="new_passwd2">Repeat New Password:</label><br/>
                <input type="password" name="new_passwd2" id="new_passwd2" size="16" maxlength="16" required />
            </p>
            <button type="submit">Change Password</button>
        </div>
    </form>

<?php
}

function display_forgot_form(){
    // display HTML form to reset and email password
?>

    <br>
    <form action="forgot_passwd.php" method="post">
        <div class="formblock">
            <h2>Forgot Your Password?</h2>
            <p>
                <label for="username">Enter Your Username:</label><br/>
                <input type="text" name="username" id="username" size="16" maxlength="16" required />
            </p>
            <button type="submit">Change Password</button>
        </div>
    </form>

<?php
}

function display_recommend_urls($url_array){
    // similar output to display_user_urls
    // instead of displaying the users bookmarks, display recommendation
?>
    <br>
    <table width="300" cellpadding="2" cellspacing="0">
        <?php
            $color="#cccccc";
            echo '<tr bgcolor="'.$color.'"><td><strong>Recommendations</strong></td></tr>';
            if(is_array($url_array) && (count($url_array) > 0)){
                foreach($url_array as $url){
                    if($color=="#cccccc"){
                        $color="#ffffff";
                    }else{
                        $color="#cccccc";
                    }
                    echo '<tr bgcolor="'.$color.'"><td><a href="'.$url.'">'.htmlspecialchars($url).'</a></td></tr>';
                }
            }else{
                echo '<tr><td>No recommendations for you today.</td></tr>';
            }
        ?>
        
    </table>

<?php
}

?>
