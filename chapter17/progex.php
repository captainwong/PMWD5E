<?php
chdir('uploads/');

// exec version
echo '<h1>Using exec()</h1>';
echo '<pre>';
exec('ls -la', $result);
foreach($result as $line){
    echo $line.PHP_EOL;
}
echo '</pre><hr />';

// passthru version
echo '<h1>Using passthru()</h1>';
echo '<pre>';
passthru('ls -la');
echo '</pre><hr />';

// system version
echo '<h1>Using system()</h1>';
echo '<pre>';
system('ls -la');
echo '</pre><hr />';

// backticks version
echo '<h1>Using Backticks</h1>';
echo '<pre>';
echo `ls -la`;
echo '</pre>';


?>