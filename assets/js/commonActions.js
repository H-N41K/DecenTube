$(document).ready(function() {
    
    $(".navShowHide").on("click", function() {
        
        var main = $("#mainSectionContainer");
        var stackNavButton = $("#stackNavButton");
        var closeNavButton = $("#closeNavButton");
        var tabList = $(".tabList");
        var nav = $("#sideNavContainer");

        if(main.hasClass("leftPadding")) {
            nav.hide();
        }
        else {
            nav.show();
        }
        stackNavButton.toggleClass("hideNavButton");
        closeNavButton.toggleClass("hideNavButton");
        main.toggleClass("leftPadding");
        tabList.toggleClass("leftPadding");
    });

});

function notSignedIn() {
    alert("You must be signed in to perform this action!");
}