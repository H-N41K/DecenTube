<?php

class NavigationMenuProvider {

    private $con, $userLoggedInObj;

    public function __construct($con, $userLoggedInObj) {
        $this->con = $con;
        $this->userLoggedInObj = $userLoggedInObj;
    }

    public function create() {
        $menuHtml = $this->createNavItem("Home", "assets/images/icons/home.png", "index.php", "style='filter: brightness(3.5);'", "");
        $menuHtml .= $this->createNavItem("Trending", "assets/images/icons/trending.png", "trending.php", "style='filter: brightness(3.5);'","");
        $menuHtml .= $this->createNavItem("Subscriptions", "assets/images/icons/subscriptions.png", "subscriptions.php", "style='filter: brightness(3.5);'", "");
        $menuHtml .= $this->createNavItem("Liked Videos", "assets/images/icons/thumb-up.png", "likedVideos.php", "style='filter: brightness(3.5);'", "");
        $menuHtml .= $this->createNavItem("Report", "assets/images/icons/report.png", "report.php", "style='filter: brightness(3.5);'", "");
    
        if(User::isLoggedIn()) {
            $menuHtml .= $this->createNavItem("History", "assets/images/icons/history.png", "history.php", "style='filter: brightness(3.5);'", "");
            $menuHtml .= $this->createNavItem("Settings", "assets/images/icons/settings.png", "settings.php", "style='filter: brightness(3.5);'", "");
            $menuHtml .= $this->createNavItem("Log Out", "assets/images/icons/logout.png", "logout.php", "style='filter: brightness(3.5);'", "");
            $menuHtml .= $this->createBalanceSection();    
            $menuHtml .= $this->createSubscriptionsSection();
                
        }

        $menuHtml .= "<br><span class='heading'>2019 &copy; DecenTube, LLC</span>";
        

        return "<div class='navigationItems'>
                $menuHtml
                </div>";
    }

    private function createNavItem($text, $icon, $link, $style, $extraNavClass) {
        return "<div class='navigationItem'>
                    <a href='$link'>
                        <img src='$icon' $style >
                        <span class='$extraNavClass'>$text</span>
                    </a>
                </div>";
    }

    private function createSubscriptionsSection() {
        $subscriptions = $this->userLoggedInObj->getSubscriptions();

        $html = "<span class='heading'>Subscriptions</span>";
        foreach($subscriptions as $sub) {
            $subUsername = $sub->getUsername();
            $html .= $this->createNavItem($subUsername, $sub->getProfilePic(), "profile.php?username=$subUsername", "style='width: 30px; height: 30px; border-radius:50%'", "");
        }

        return $html;

    }

    private function createBalanceSection() {

        $html = "<span class='heading'>Balance</span>";
        $html .= $this->createNavItem("", "assets/images/icons/coin.svg", "#", "style='width: 30px; height: 30px; border-radius:50%; //filter: invert(1);'", "balanceDisplay");
        $html .= $this->createNavItem("Buy / Sell DTC", "assets/images/icons/buy-sell-tokens.png", "tokenMarketplace.php", "style='width: 30px; height: 30px; border-radius:50%; filter: invert(1);'", "");
        return $html;

    }
}

?>