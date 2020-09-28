<?php
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No category ID passed to the page");
}

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
?>