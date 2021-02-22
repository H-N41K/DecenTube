function subscribe(userTo, userFrom, button) {
   
    if(userTo == userFrom) {
        alert("You can't subscribe to yourself");
        return
    }

    if(window.currentAccount != getUserEthAddress()){
        alert('There is an inconsistency between MetaMask wallet and User Session. Please set both to the same account and try again.');
        return false;
    }

    video_user = getVideoUser();

    window.videossharing.methods.subscribe_user(video_user).send({ from: window.currentAccount }, function(error, result){
        if(error) 
        {
        console.log('Error is '+error);
        return;
        }
        
        $.post("ajax/subscribe.php", {userTo: userTo, userFrom: userFrom})
        .done(function (count) {

        if(count != null) {
            $(button).toggleClass("subscribe unsubscribe");

            var buttonText = $(button).hasClass("subscribe") ? "SUBSCRIBE" : "SUBSCRIBED 🔔";
            $(button).text(buttonText + " " + count)
        }
        else {
            alert("something went wrong!");
        }

        });
        });

    

}