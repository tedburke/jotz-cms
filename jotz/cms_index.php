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
$articles_count = trim($output[0]);

// Count this user's file uploads
$output = null;
$retval = null;
$command = 'ls ../uploads/* | wc -l';
exec($command, $output, $retval);
$uploads_count = trim($output[0]);

// Get this user's disk usage
$output = null;
$retval = null;
$command = 'du --exclude=\'trash\' -s --block-size=1M ..';
exec($command, $output, $retval);
$words = preg_split("/[\s,]+/", trim($output[0]));
$storage_used_MB = $words[0];

// Count words in this user's articles
$output = null;
$retval = null;
$command = 'cat ../markdown/*.md | wc -w';
exec($command, $output, $retval);
$words_count = trim($output[0]);

// Define limits
// In due course, these limits should be read from a user-specific config file
$articles_max = 6;
$words_max = 2400;
$uploads_max = 24;
$storage_max_MB = 24;

// Print user stats
echo("<div class='analytics'>" . PHP_EOL);
$limit_class = $words_count > $words_max ? "exceeded_limit" : "within_limit";
echo("<span class='$limit_class'>" . $words_count . " / " . $words_max . " words</span> , ");
$limit_class = $articles_count > $articles_max ? "exceeded_limit" : "within_limit";
echo("<span class='$limit_class'>" . $articles_count . " / " . $articles_max . " articles</span> , ");
$limit_class = $uploads_count > $uploads_max ? "exceeded_limit" : "within_limit";
echo("<span class='$limit_class'>" . $uploads_count . " / " . $uploads_max . " uploads</span> , ");
$limit_class = $storage_used_MB > $storage_max_MB ? "exceeded_limit" : "within_limit";
echo("<span class='$limit_class'>" . $storage_used_MB . " / " . $storage_max_MB . " MB storage used</span>" . PHP_EOL);
echo ("</div>" . PHP_EOL);

include("footer.php");
?>

