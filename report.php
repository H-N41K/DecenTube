<?php 
require_once("includes/header.php");
require_once("includes/classes/FormSanitizer.php");
require_once("includes/classes/Constants.php");
require_once("includes/classes/VideoDetailsFormProvider.php");
require_once("includes/classes/Account.php");

if(!User::isLoggedIn()) {
    header("Location: signIn.php");
  }
$detailsMessage = "";
if(isset($_POST["reportButton"])) {

    $account = new Account($con);
    $videoUrl = FormSanitizer::sanitizeUrl($_POST["videoUrlInput"]);
    $reportCategory = FormSanitizer::sanitizeFormString($_POST["reportCategoryInput"]);
    $reportComments = FormSanitizer::sanitizeFormString($_POST["reportCommentsInput"]);

    if($account->reportVideo($videoUrl, $reportCategory, $reportComments, $userLoggedInObj->getUsername())) {
        $detailsMessage = "<div class='alert alert-success' style='color: #ffffff;background-color: #116524;border-color: #c3e6cb;'>
                                <strong>SUCCESS!</strong> Report submitted successfully!
                            </div>";
    }
    else {
        $errorMessage = $account->getFirstError();

        if($errorMessage == "") $errorMessage = "Something went wrong";

        $detailsMessage = "<div class='alert alert-danger' style='color: #ffffff;background-color: #d60c0c;border-color: #c3e6cb;'>
                                <strong>ERROR!</strong> $errorMessage
                            </div>";
    }

}

?>
<div class="formSection">
<div class="column">
    <h1>Report a video!</h1>
    
    <div class="message">
            <?php echo $detailsMessage; ?>
    </div>
    <?php
    $formProvider = new VideoDetailsFormProvider($con);
    echo $formProvider->createReportForm();
    ?>


</div>
</div>

<?php
require_once("includes/footer.php");
?>