<?php
// LOAD CUSTOM FOOTER HTML IF IT EXISTS, OTHERWISE DISPLAY DEFAULT FOOTER

// Default footer is currently blank
$footer = '';

// Load custom foooter
if (file_exists('custom/custom_footer.html')) $footer = file_get_contents('custom/custom_footer.html');
$footer = trim($footer);

// Display footer
echo ($footer);
?>

</body>
</html>

