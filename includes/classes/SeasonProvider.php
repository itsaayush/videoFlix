<?php

class SeasonProvider{
    private $conn, $username;

    public function __construct( $conn, $username){
        $this->conn=$conn;
        $this->username=$username;
    }
    public function seasonChange(){

    }
    public function create($entity,$selectedSeasonNumber){
        $allSeason = $entity->getSeasons(null);
        if($selectedSeasonNumber == null){
            $selectedSeasonNumber=1;
        }
        $selectedSeason = $entity->getSeasons($selectedSeasonNumber);
        $entityId= $entity->getId();
        $totalSeasons = sizeof($allSeason);
        if($totalSeasons == 0){
            return;
        }
        $seasonsHtml = "";
        foreach($allSeason as $season){
            $seasonNumber = $season->getSeasonNumber();

            $videoHtml="";
            foreach($selectedSeason[0]->getVideos() as $video){
                $videoHtml.=$this->createVideoSquare($video);
            }

            $seasonsHtml.="<option value='$seasonNumber'>Season $seasonNumber</option>";
        }
        $selectList = "<div class='seasonsList'>
                    <select id='seasonList' name='seasonList' onchange='seasonChange(this.value,$entityId)' >
                        $seasonsHtml; 
                    </select>
                    <div class='videos'>
                        $videoHtml
                    </div>
                </div>";    
        return $selectList;
    }

    private function createVideoSquare($video){
        $id = $video->getId();
        $thumbnail = $video->getThumbnail();
        $description = $video->getDescription();
        $title = $video->getTitle();
        $episodeNumber= $video->getEpisodeNumber();
        $hasSeen = $video->hasSeen($this->username) ? "<i class='fas fa-check-circle seen'></i>" : "" ;
        return "<a href='watch.php?id=$id'>
                    <div class='episodeContainer'>
                        <div class='contents'>
                            <img src='$thumbnail'>
                            <div class='videoInfo'>
                                <h4>$episodeNumber. $title</h4>
                                <span>$description</span>
                            </div>

                            $hasSeen
                        </div>
                    </div>
                </a>";
    }

    public function seasonChangeHandler($seasonNumber){
        $seasonProvider = new SeasonProvider($conn, $userLoggedIn);
        echo $seasonProvider->create($entity,$seasonNumber);
    }
}

?>
