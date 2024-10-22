<?php
include("header.php");

// If upload form was submitted as POST request, write uploaded file to uploads directory
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $target_file = "../uploads/" . basename($_FILES["file_to_upload"]["name"]);
  
  if (strncmp(basename($_FILES["file_to_upload"]["name"]), ".htaccess", 1) == 0)
  {
    echo "<p>Error: Filenames starting with '.' are not allowed</p>" . PHP_EOL;
  }
  else if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file))
  {
    echo "Upload succeeded.<br>";
  }
  else
  {
    echo "Error uploading file.<br>";
  }
}
?>

<h2>Upload file</h2>

<form action="upload.php" method="post" enctype="multipart/form-data">
  Select file to upload (max file size 4MB):
  <input type="file" name="file_to_upload" id="file_to_upload">
  <input type="submit" value="Upload File" name="submit">
</form>

<h2>Uploaded files</h2>

<?php
echo "<ul>" . PHP_EOL;
foreach (glob('../uploads/*') as $file)
{
  $rellink = "uploads/" . basename($file);
  $fext = strtolower(substr($rellink, -4)); // file extension
  echo('<li><a href="../' . $rellink . '">' . basename($file) . '</a>&nbsp;&nbsp;&nbsp;(<a href="delete.php?dirname=uploads&filename=' . basename($file) . '" target="jotz_delete_article_tab">delete</a>)</li>' . PHP_EOL);

  if (in_array($fext, array('.jpg', '.png', '.bmp', '.svg', 'jpeg'), true))
  {
    $rellink_nospaces = str_replace(" ", "%20", $rellink);
    echo('To embed image:<br>' . PHP_EOL);
    echo('<tt>![insert alt text here](' . $rellink_nospaces . ' "insert image title here")</tt><br>');
  }
  else
  {
    echo('File link:<br>' . PHP_EOL);
    echo('<tt>' . $rellink . '</tt><br>');
  }
}
echo "</ul>" . PHP_EOL;

include("footer.php");
?>

