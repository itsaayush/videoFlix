<?php 
require_once("../includes/config.php");
require_once("../includes/classes/SearchResultsProvider.php");
require_once("../includes/classes/EntityProvider.php");
require_once("../includes/classes/PreviewProvider.php");
require_once("../includes/classes/Entity.php");




if(isset($_POST["term"]) && isset($_POST["username"])){
    $srp = new SearchResultsProvider($conn, $_POST["username"]);
    echo $srp->getResults($_POST["term"]);
}else {
    echo "No username or searchterm passed into file";
}
?>