<?php
require_once("includes/header.php");

$preview = new PreviewProvider($conn, $userLoggedIn);
echo $preview->createMoviesPreviewVideo();

$containers = new CategoryContainers($conn, $userLoggedIn);
echo $containers->showMoviesCategories();
?>