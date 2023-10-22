<?php
include("header.php");

echo "<ul>" . PHP_EOL;
$arrFiles = scandir("../markdown");

foreach ($arrFiles as $filename)
{
  if (substr($filename, -3) != '.md') continue;
  $title = "";
  $lines = file("../markdown/" . $filename);
  foreach ($lines as $line)
  {
    $line = trim($line);
    if (substr($line, 0, 6) == "title:")
    {
      $title = trim(substr($line, 6));
      break;
    }
  }
  
  echo "<li><a href=\"edit.php?mdfile=$filename\">$title</a></li>" . PHP_EOL;
}
echo "</ul>" . PHP_EOL;

include("footer.php");
?>

