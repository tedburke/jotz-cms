<?php
include("header.php");

// List articles
$arrFiles = scandir("markdown", SCANDIR_SORT_DESCENDING);
foreach ($arrFiles as $filename)
{
  if (substr($filename, -3) != '.md') continue;
  $title = "";
  $lines = file("markdown/" . $filename);
  foreach ($lines as $line)
  {
    $line = trim($line);
    if (substr($line, 0, 6) == "title:")
    {
      $title = trim(substr($line, 6));
      break;
    }
  }

  echo "<div style=\"clear:both;\">" . PHP_EOL;
  echo "<div style=\"width:8em;text-align:center;float:left;\">" . date("Y-m-d", filemtime("markdown/" . $filename)) . "</div>" . PHP_EOL;
  echo "<div style=\"width:calc(100% - 9em);float:left;\"><a href=\"view.php?mdfile=$filename\">$title</a></div>" . PHP_EOL;
  echo "</div>" . PHP_EOL;
}

include("footer.php");
?>

