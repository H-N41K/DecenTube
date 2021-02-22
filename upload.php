<?php 
require_once("includes/header.php");
require_once("includes/classes/VideoDetailsFormProvider.php");

if(!User::isLoggedIn()) {
  header("Location: signIn.php");
}
?>


<div class="column">
    <h1>Upload Video !</h1>
    <!-- <h5>Error #23800 Uploading service has been temporarily disabled. It will be made functional very soon!</h5> -->
    <?php
    $formProvider = new VideoDetailsFormProvider($con);
    echo $formProvider->createUploadForm();
    ?>


</div>

<script>
$("form").submit(function() {
    $("#loadingModal").modal("show");
});
</script>



<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" aria-labelledby="loadingModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="background-color:black;">
      
      <div class="modal-body">
        Please wait. This might take a while.
        <img src="assets/images/icons/loading-spinner.gif" style="width: 45%;">
      </div>

    </div>
  </div>
</div>




<?php require_once("includes/footer.php"); ?>
                