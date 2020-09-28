<?php

require_once("includes/header.php");



if(!isset($_GET["id"])){
    ErrorMessage::show("No video is selected (ID not passed)");
}

$entityId = $_GET["id"];
$entity = new Entity($conn, $entityId);





function seasonChange($seasonNumber){
    $userLoggedIn= $_SESSION['userLoggedIn'];
    try{
        $conn = new PDO("mysql:dbname=videoflix;host=localhost", "root","");
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    
    }catch(PDOException $e){
        exit("Connection failed:".$e->getMessage());
    }
    $entityId = $_GET["id"];
    $entity = new Entity($conn, $entityId);
    $preview = new PreviewProvider($conn, $userLoggedIn );
    echo $preview->createPreviewVideo($entity);

    $seasonProvider = new SeasonProvider($conn, $userLoggedIn);
    echo $seasonProvider->create($entity,$seasonNumber);

    $categoryContainers = new CategoryContainers($conn, $userLoggedIn);
    echo $categoryContainers->showCategory($entity->getCategoryId(),"You might also Like");

}

if(isset($_POST['function2call']) && isset($_POST['season'])  && !empty(($_POST['function2call']))){
    $seasonNumber = $_POST['season'];
    seasonChange($_POST['season']);
}else{
    $preview = new PreviewProvider($conn, $userLoggedIn);
    echo $preview->createPreviewVideo($entity);
    
    $seasonProvider = new SeasonProvider($conn, $userLoggedIn);
    echo $seasonProvider->create($entity,null);

    $categoryContainers = new CategoryContainers($conn, $userLoggedIn);
    echo $categoryContainers->showCategory($entity->getCategoryId(),"You might also Like");
}



?>

<script>
    
</script>

