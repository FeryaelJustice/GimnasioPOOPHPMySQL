<?php
// DB
require './database/db.php';
?>
<?php
// Header
require './partials/header.php';
?>

<?php
// Content
if (in_array($page, allowed)) {
    include("./pages/$page.php");
} else {
    include("./pages/404.php");
}
?>

<?php
// Footer
require './partials/footer.php';
?>