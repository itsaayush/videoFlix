<?php
$hideNav=false;
require_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No video is selected (ID not passed)");
}

$user = new User($conn, $userLoggedIn);

if(!$user->getIsSubscribed()){
    ErrorMessage::show("You must be subscribed to see this.<br>
                        <a href='profile.php' class='linkColor'>Click here to subscribe</a>");
}

$video = new Video($conn, $_GET["id"]);
$video->incrementViews();
$upNextVideo = VideoProvider::getUpNext($conn, $video);

?>


<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onClick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext" style="display:none;">
        <button onClick="restartVideo()"><i class="fas fa-redo"></i></button>
        <div class="upNextContainer">
            <h2>Up Next:</h2>
            <h3><?php echo $upNextVideo->getTitle()?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode()?></h3>
        
            <button class="playNext" onClick ="watchVideo(<?php echo $upNextVideo->getId();?>)"><i class="fas fa-play"> Play</i></button>
        </div>
    </div>

    <video controls autoplay onended="showUpNext()">
        <source src='<?php echo $video->getFilePath();?>' type="video/mp4">
    </video>
</div>

<script>
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>