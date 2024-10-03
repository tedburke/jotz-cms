<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="analytics.css">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />
  <title>jotz analytics</title>
</head>
<body>
<pre class="asciiart">
      _       _                           _       _   _          
     | | ___ | |_ ____   __ _ _ __   __ _| |_   _| |_(_) ___ ___ 
  _  | |/ _ \| __|_  /  / _` | '_ \ / _` | | | | | __| |/ __/ __|
 | |_| | (_) | |_ / /  | (_| | | | | (_| | | |_| | |_| | (__\__ \
  \___/ \___/ \__/___|  \__,_|_| |_|\__,_|_|\__, |\__|_|\___|___/
                                            |___/                
</pre>

<?php
// If a specific markdown file was specified, skip other files
($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user'])) or die ("Error: user(s) must be specified as URL parameters");

$users = $_GET['user'];

echo('<h1>Users</h1>' . PHP_EOL);

echo("<table>" . PHP_EOL);
echo("<tr> <th>User</th> <th>Articles</th> <th>File uploads</th> <th>Lines of text</th> <th>Word count</th> <th>Character count</th> <th>Disk usage [kB]</th> </tr>" . PHP_EOL);

$csv = "User,Articles,File uploads,Lines of text,Word count,Character count,Disk usage" . PHP_EOL;

foreach ($users as $user)
{
  // Count this user's articles
  $output = null;
  $retval = null;
  $command = 'ls ../' . $user . '/markdown/*.md | wc -l';
  exec($command, $output, $retval);
  $article_count = trim($output[0]);

  // Count this user's file uploads
  $output = null;
  $retval = null;
  $command = 'ls ../' . $user . '/uploads/* | wc -l';
  exec($command, $output, $retval);
  $upload_count = trim($output[0]);
  
  // Get this user's disk usage
  $output = null;
  $retval = null;
  $command = 'du -s ../' . $user;
  exec($command, $output, $retval);
  $words = preg_split("/[\s,]+/", trim($output[0]));
  $kB_count = $words[0];

  // Count lines, words and characters in this user's articles
  $output = null;
  $retval = null;
  $command = 'cat ../' . $user . '/markdown/*.md | wc';
  exec($command, $output, $retval);
  $words = explode(" ", $output[0]);
  while (($word = array_shift($words)) == '');
  $line_count = $word;
  while (($word = array_shift($words)) == '');
  $word_count = $word;
  while (($word = array_shift($words)) == '');
  $character_count = $word;
  
  // Print a table row containing this user's stats
  echo("<tr> <td><a href=\"../$user\">$user</a></td> <td>$article_count</td> <td>$upload_count</td> <td>$line_count</td> <td>$word_count</td> <td>$character_count</td> <td>$kB_count</td> </tr>" . PHP_EOL);
  
  // Also add this user's stats to the CSV string
  $csv = $csv . "$user,$article_count,$upload_count,$line_count,$word_count,$character_count,$kB_count" . PHP_EOL;
}
echo("</table>" . PHP_EOL);

echo('<h1>Data in CSV format</h1>' . PHP_EOL);
echo("<pre>" . PHP_EOL . $csv . "</pre>" . PHP_EOL);
?>

