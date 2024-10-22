<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Default values for article content
$article_id = date("Ymd_His",time());
$article_title = "untitled";
$article_markdown = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	// Completed form was submitted	
	if (isset($_POST['article_id'])) $article_id = $_POST['article_id'];
	if (isset($_POST['article_title'])) $article_title = $_POST['article_title'];
	if (isset($_POST['article_markdown'])) $article_markdown = $_POST['article_markdown'];

	// Write markdown file
	$f = fopen("../markdown/" . $article_id . ".md", "w") or die("Unable to open markdown file!");
	fwrite($f, "---" . PHP_EOL);
	fwrite($f, "title: " . $article_title . PHP_EOL);
	fwrite($f, "..." . PHP_EOL . PHP_EOL);
	fwrite($f, $article_markdown);
	fclose($f);
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mdfile']))
{
	// Existing markdown file was specified	
	$filename = "../markdown/" . $_GET['mdfile'];
	
	if (!file_exists($filename)) die("ERROR: Specified markdown file $filename not found");
	if (substr($_GET['mdfile'], -3) != '.md') die ("ERROR: File extension must be .md");
	
	$article_id = substr($_GET['mdfile'], 0, -3);

	// Parse markdown file using state machine.
	$lines = file($filename);
	$parse_state = 0;
	foreach ($lines as $line)
	{
		if ($parse_state == 0) // State 0 until start of metadata
		{
			if (trim($line) == "---") $parse_state = 1;
		}
		else if ($parse_state == 1) // State 1 until title is found
		{
			$line = trim($line);
			if (substr($line, 0, 6) == 'title:')
			{
				$article_title = trim(substr($line, 6));
				$parse_state = 2;
			}
		}
		else if ($parse_state == 2) // State 2 until end of metadata
		{
			if (trim($line) == "..." or trim($line) == "---") $parse_state = 3;			
		}
		else if ($parse_state == 3) // State 3 until first non-blank line of markdown
		{
			if (trim($line) != "")
			{
				$parse_state = 4;
				$article_markdown .= $line;
			}
		}
		else if ($parse_state == 4) // State 4 once markdown has started
		{
			$article_markdown .= $line;
		}
	}
	
	if ($parse_state < 3) die ("ERROR: Metadata is incomplete in $filename");
}
else
{
	// New article
	$article_id = date("Ymd_His",time());
	$article_title = "Write article title here";
	$article_markdown = "Write markdown here...";
}

include("header.php");
?>

<h1>Jotz CMS editor</h1>

<form action="edit.php" id="edit_form" method="post">
  <label for="article_title">Article title:</label>
  <input type="hidden" id="id" name="article_id" value="<?php echo($article_id);?>">
  <input type="text" id="title" name="article_title" value="<?php echo($article_title);?>">
  <input type="submit" value="Create / update article">
  <?php
    if (file_exists("../markdown/$article_id.md"))
    {
      echo ('&nbsp;&nbsp;<a href="../view.php?mdfile=' . $article_id . '.md" target="jotz_view_post" rel="noopener noreferrer">View post in new tab</a>');
      echo ('&nbsp;&nbsp;<a href="delete.php?dirname=markdown&filename=' . $article_id . '.md" target="_blank" rel="noopener noreferrer">Delete this post...</a>');
    }
  ?>
</form>

<textarea name="article_markdown" form="edit_form"><?php echo $article_markdown;?></textarea>

<?php
include("footer.php");
?>

