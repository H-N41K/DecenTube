<?php
class VideoGrid {

    private $con, $userLoggedInObj, $currentlyPlayingVideoId, $showCategory;
    private $largeMode = false;
    private $gridClass = "videoGrid";

    public function __construct($con, $userLoggedInObj, $currentlyPlayingVideoId, $showCategory) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
        $this->currentlyPlayingVideoId = $currentlyPlayingVideoId;
        $this->showCategory = $showCategory;
    }

    public function create($videos, $title, $showFilter) {

        if($videos == null) {
            $gridItems = $this->generateItems();
        }
         else {
            $gridItems = $this->generateItemsFromVideos($videos);
        }

        $header = "";

        if($title != null) {
            $header = $this->createGridHeader($title, $showFilter);
        }

        return "$header
                <div class='$this->gridClass'>
                $gridItems
                </div>";
    }

    public function generateItems() {
        if($this->currentlyPlayingVideoId != null){
            $query = $this->con->prepare("SELECT * FROM videos WHERE transactionStatus=1 AND id <>:currentlyPlayingVideoId AND privacy=1 ORDER BY RAND() LIMIT 18 ");
            $query->bindParam(":currentlyPlayingVideoId", $this->currentlyPlayingVideoId);
            $query->execute();
        } else {
            $query = $this->con->prepare("SELECT * FROM videos WHERE transactionStatus=1 AND privacy=1 ORDER BY RAND() LIMIT 18");
            $query->execute();
        }
        

        $elementsHtml = "";
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video($this->con, $row, $this->userLoggedInObj);
            $item = new VideoGridItem($video, $this->largeMode, $this->showCategory);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
    }

    public function generateItemsFromVideos($videos) {
        $elementsHtml = "";

        foreach($videos as $video) {
            $item = new VideoGridItem($video, $this->largeMode, $this->showCategory);
            $elementsHtml .= $item->create();
        }

        return $elementsHtml;
    }

    public function createGridHeader($title, $showFilter) {
        $filter = "";
        
        if($showFilter) {
            $link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $urlArray = parse_url($link);
            $query = $urlArray["query"];

            parse_str($query, $params);
            
            unset($params["orderBy"]);

            $newQuery = http_build_query($params);

            $newUrl = basename($_SERVER["PHP_SELF"]) . "?" . $newQuery;

            $filter = "<div class='right'>
                        <span>Order by:&nbsp;&nbsp;</span>
                        <a href='$newUrl&orderBy=uploadDate' style='color: chartreuse;'>Upload date</a>
                        <a href='$newUrl&orderBy=views' style='color: chartreuse;'>Most viewed</a>
                        </div>";
            
        }

        return "<div class='videoGridHeader'>
                    <div class='left'>
                        $title
                    </div>
                    $filter
                   </div>";
    }

    public function createLarge($videos, $title, $showFilter) {
        $this->gridClass .= " large";
        $this->largeMode = true;
        return $this->create($videos, $title, $showFilter);
    }
}
?>