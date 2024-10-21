<?php
include("header.php");

// Display list of articles
$arrFiles = scandir("../markdown", SCANDIR_SORT_DESCENDING);
foreach ($arrFiles as $filename)
{
  if (substr($filename, -3) != '.md') continue;
  $article_title = "";
  $lines = file("../markdown/" . $filename);
  foreach ($lines as $line)
  {
    $line = trim($line);
    if (substr($line, 0, 6) == "title:")
    {
      $article_title = trim(substr($line, 6));
      break;
    }
  }

  // Create a string containing the date the article was first posted
  try
  {
    // Try to use the timestamp in the filename
    $hour = (int)substr($filename,9,2);
    $minute = (int)substr($filename,11,2);
    $second = (int)substr($filename,13,2);
    $month = (int)substr($filename,4,2);
    $day = (int)substr($filename,6,2);
    $year = (int)substr($filename,0,4);
    $file_time = mktime($hour,$minute,$second,$month,$day,$year);
    $article_date = date("Y-m-d", $file_time);
  }
  catch (Throwable $e)
  {
      // If the date cannot be retrieved from the filename, use filemtime instead
      $article_date = date("Y-m-d", filemtime("../markdown/" . $filename));
  }

  echo "<div class=\"article_list_article\">" . PHP_EOL;
  echo "<div class=\"article_list_date\">" . $article_date . "</div>" . PHP_EOL;
  echo "<div class=\"article_list_title\"><a href=\"edit.php?mdfile=$filename\">$article_title</a></div>" . PHP_EOL;
  echo "</div>" . PHP_EOL;
}

// Display analytics for this user's blog

// Count articles
$output = null;
$retval = null;
$command = 'ls ../markdown/*.md | wc -l';
exec($command, $output, $retval);
$article_count = trim($output[0]);

// Count this user's file uploads
$output = null;
$retval = null;
$command = 'ls ../uploads/* | wc -l';
exec($command, $output, $retval);
$upload_count = trim($output[0]);

// Get this user's disk usage
$output = null;
$retval = null;
$command = 'du -s ..';
exec($command, $output, $retval);
$words = preg_split("/[\s,]+/", trim($output[0]));
$kB_count = $words[0];

// Count lines, words and characters in this user's articles
$output = null;
$retval = null;
$command = 'cat ../markdown/*.md | wc';
exec($command, $output, $retval);
$words = explode(" ", $output[0]);
while (($word = array_shift($words)) == '');
$line_count = $word;
while (($word = array_shift($words)) == '');
$word_count = $word;
while (($word = array_shift($words)) == '');
$character_count = $word;

// Print user stats
echo ("<div class=\"analytics\">" . PHP_EOL);
echo("Articles: $article_count (");
echo ("$line_count lines, $word_count words, $character_count characters)<br>" . PHP_EOL);
echo("Uploads: $upload_count<br>" . PHP_EOL);
echo("Storage used: $kB_count<br>" . PHP_EOL);
echo ("</div>" . PHP_EOL);
  
include("footer.php");
?>

