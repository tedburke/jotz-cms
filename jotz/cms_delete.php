<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("header.php");

if ($_SERVER['REQUEST_METHOD'] != 'GET' or !isset($_GET['filename']) or !isset($_GET['dirname']))
{
	// Not a GET request or filename not provided
	die('Error: no file specified');
}

$filename = basename($_GET['filename']);
$dirname = $_GET['dirname'];

if ($dirname != 'uploads' and $dirname != 'markdown')
{
	die('Error: invalid directory specified');
}

if (!file_exists('../' . $dirname . '/' . $filename))
{
	die('Error: file ' . '../' . $dirname . '/' . $filename . ' does not exist');
}

if (isset($_GET['confirmed']) and $_GET['confirmed'] == '1')
{
  echo "<p>Deleting file $dirname/$filename...";
  //exec("rm ../$dirname/$filename");
  exec("mv ../$dirname/\"$filename\" ../trash/");
  echo "DONE</p>";
}
else
{
  echo ("<p>Are you sure you want to delete $dirname/$filename?</p>");
  echo ("<a href=\"delete.php?dirname=$dirname&filename=$filename&confirmed=1\">Delete file</a><br>");
  echo ("<a href=\"../cms\">Cancel</a><br>");
}

include("footer.php");
?>

