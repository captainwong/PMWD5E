<?php
require_once('bookmark_fns.php');
session_start();

do_html_header('Add Bookmarks');

check_valid_user();