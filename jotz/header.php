<?php $username = basename(getcwd()); ?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="jotz.css">
  <?php
    if (file_exists('custom/custom.css')) echo ('<link rel="stylesheet" href="custom/custom.css">');
  ?>
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
  <title><?php echo($username); ?></title>
</head>

<body>

<?php
// Include custom header if one exists
if (file_exists('custom/custom_header.html')) $header = file_get_contents('custom/custom_header.html');
$header = trim($header);

// If no custom header was provided, load the default header
if ($header == '')
{
// Default header
$header=<<<EOD
<pre class="asciiart">
  ____       _             ____                        
 |  _ \ ___ | |__   ___   / ___| _   _ _ __ ___   ___  
 | |_) / _ \| '_ \ / _ \  \___ \| | | | '_ ` _ \ / _ \ 
 |  _ < (_) | |_) | (_) |  ___) | |_| | | | | | | (_) |
 |_| \_\___/|_.__/ \___/  |____/ \__,_|_| |_| |_|\___/ 
</pre>
EOD;
}

echo ($header);
?>

<nav>
<span><a href=".">Home</a></span>
<span><a href="cms">CMS</a></span>
<span>User: <?php echo($username); ?></span>
</nav>

