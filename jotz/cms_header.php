<?php
$username = basename(realpath(".."));
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="../jotz.css">
<?php
$icon_file = file_exists("../uploads/favicon.ico") ? "../uploads/favicon.ico" : "../../favicon.ico";
?>
  <link rel="shortcut icon" href="<?php echo($icon_file); ?>" type="image/x-icon" />
  <title>Jotz CMS <?php echo($username); ?></title>
</head>
<body>

<pre class="asciiart">
      _       _          ____ __  __ ____    _                _                     _ 
     | | ___ | |_ ____  / ___|  \/  / ___|  | |__   __ _  ___| | __   ___ _ __   __| |
  _  | |/ _ \| __|_  / | |   | |\/| \___ \  | '_ \ / _` |/ __| |/ /  / _ \ '_ \ / _` |
 | |_| | (_) | |_ / /  | |___| |  | |___) | | |_) | (_| | (__|   <  |  __/ | | | (_| |
  \___/ \___/ \__/___|  \____|_|  |_|____/  |_.__/ \__,_|\___|_|\_\  \___|_| |_|\__,_|
</pre>

<nav>
&nbsp;&nbsp;&nbsp;<a href="..">Home</a>
&nbsp;&nbsp;<a href="../cms">CMS</a>
&nbsp;&nbsp;<a href="edit.php">New article</a>
&nbsp;&nbsp;<a href="upload.php" target="jotz_upload_tab">Upload</a>
&nbsp;&nbsp;<a href="settings.php">Settings</a>
&nbsp;&nbsp;<span>User: <?php echo($username); ?></span>
</nav>

