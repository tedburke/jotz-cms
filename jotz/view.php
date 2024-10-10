<?php
require_once(getcwd() . '/cms/Parsedown.php');
$parser = new Parsedown();

include("header.php");

// Display articles
$arrFiles = scandir("markdown", SCANDIR_SORT_DESCENDING);
foreach ($arrFiles as $filename)
{
	$article_id = "no_id";
	$article_title = "untitled";
	$article_markdown = "";
 
    // If a specific markdown file was specified, skip other files
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['mdfile']))
    {
      if (basename($filename) != $_GET['mdfile']) continue;
    }
	
	// Skip non-markdown files
	if (substr($filename, -3) != '.md') continue;
	
	$article_id = substr($filename, 0, -3);

	// Parse markdown file using state machine.
	$lines = file("markdown/" . $filename);
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
	
	if ($parse_state < 3) echo ("<p>ERROR: Incomplete metadata in $filename</p>");
  
    if ($article_title == "#SEPARATOR")
    {
        // This is a dummy article included as a separator, so don't
        // display it's content and skip all remaining files.
        // i.e. When opened without specifying an article, view.php
        // displays all articles in reverse chronological order
        // until it reaches the first #SEPARATOR article.
        break;
    }
    else
    {
        // Generate HTML from markdown and add to article_html string
        echo("<h1>$article_title</h1>" . PHP_EOL);
        echo($parser->text($article_markdown) . PHP_EOL);
    }
}

include("footer.php");
?>

