<?php
include("header.php");

// List articles
$arrFiles = scandir("markdown", SCANDIR_SORT_DESCENDING);
foreach ($arrFiles as $filename)
{
  if (substr($filename, -3) != '.md') continue;
  $article_title = "";
  $lines = file("markdown/" . $filename);
  foreach ($lines as $line)
  {
    $line = trim($line);
    if (substr($line, 0, 6) == "title:")
    {
      $article_title = trim(substr($line, 6));
      break;
    }
  }
  $article_date = date("Y-m-d", filemtime("markdown/" . $filename)); 

  if ($article_title == "#SEPARATOR")
  {
    echo "<div style=\"clear:both;padding:0.75em 15% 0.5em 15%;\"><hr></div>" . PHP_EOL;
  }
  else
  {
    echo "<div style=\"clear:both;padding:0.5em 0 0.5em 0;\">" . PHP_EOL;
    echo "<div style=\"width:8em;text-align:center;float:left;\">" . $article_date . "</div>" . PHP_EOL;
    echo "<div style=\"width:calc(100% - 9em);float:left;\"><a href=\"view.php?mdfile=$filename\">$article_title</a></div>" . PHP_EOL;
    echo "</div>" . PHP_EOL;
  }
}

include("footer.php");
?>

