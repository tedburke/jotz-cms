<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("header.php");

// Set the maximum length (in characters) for each custom content item
$max_length = 10000;

$update_confirmation_message = "";

// If form was form was submitted, update custom content files
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && 
      isset($_POST['custom_css']) &&
      isset($_POST['custom_header']) &&
      isset($_POST['custom_footer']) )
{
	// Retrieve custom content from POST request parameters
    // Limit the length in characters of each time to $max_length (set above)
	$custom_css = substr(trim($_POST['custom_css']), 0, $max_length);
	$custom_header = substr(trim($_POST['custom_header']), 0, $max_length);
	$custom_footer = substr(trim($_POST['custom_footer']), 0, $max_length);

	// Update custom content files
    if (file_put_contents('../custom/custom.css', $custom_css) === false) die("Error: Unable to write custom.css!");
    if (file_put_contents('../custom/custom_header.html', $custom_header) === false) die("Error: Unable to write custom_header.html!");
    if (file_put_contents('../custom/custom_footer.html', $custom_footer) === false) die("Error: Unable to write custom_footer.html!");
    
    // Prepare a message to be displayed below confirming files were updated
    $update_confirmation_message = "Settings updated at " . date("H:i:s d-m-Y");
}

// FROM HERE ON, WE PROCEED THE SAME WHETHER FORM WAS SUBMITTED OR NOT

// Default content for custom CSS, header and footer 
$custom_css = '';
$custom_header = '';
$custom_footer = '';

// Load custom CSS, header and footer from files if they exist
if (file_exists('../custom/custom.css')) $custom_css = file_get_contents('../custom/custom.css', false, null, 0, $max_length);
if (file_exists('../custom/custom_header.html')) $custom_header = file_get_contents('../custom/custom_header.html', false, null, 0, $max_length);
if (file_exists('../custom/custom_footer.html')) $custom_footer = file_get_contents('../custom/custom_footer.html', false, null, 0, $max_length);

// Trim leading and trailing whitespace
$custom_css = trim($custom_css);
$custom_header = trim($custom_header);
$custom_footer = trim($custom_footer);
?>

<h1>Jotz CMS settings</h1>

<form action="settings.php" id="settings_form" method="post">
  <input type="submit" value="Update settings">
  <?php echo ("&nbsp;&nbsp;<span>" . $update_confirmation_message . "</span>"); ?>
</form>

<h2>Custom CSS</h2>
<p>Custom CSS code added here will be applied when articles are viewed (in addition to the default Jotz CSS).</p>
<textarea name="custom_css" form="settings_form"><?php echo($custom_css); ?></textarea>
<h2>Custom header HTML</h2>
<p>Insert HTML here to create a custom header that will be displayed above all articles. The custom header will replace the default ascii art article header. To restore the default header, just set the custom header to be blank.</p>
<textarea name="custom_header" form="settings_form"><?php echo($custom_header); ?></textarea>
<h2>Custom footer HTML</h2>
<p>Insert HTML here to create a custom footer that will be displayed below all articles. The custom footer will replace the default footer. To restore the default footer, just set the custom footer to be blank.</p>
<textarea name="custom_footer" form="settings_form"><?php echo($custom_footer); ?></textarea>

<?php
include("footer.php");
?>

