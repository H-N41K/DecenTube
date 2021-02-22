<?php 
class VideoDetailsFormProvider {

	private $con;

	public function __construct($con) {
		$this->con = $con;
	}

	public function createUploadForm() {
		$fileInput = $this->createFileInput();
		$titleInput = $this->createTitleInput(null);
		$descriptionInput = $this->createDescriptionInput(null);
		$privacyInput = $this->createPrivacyInput(null);
		$categoriesInput = $this->createCategoriesInput(null);
		$uploadButton = $this->createUploadButton();

		return "<form action='processing.php' method='POST' enctype='multipart/form-data'>
					$fileInput
					$titleInput
					$descriptionInput
					$privacyInput
					$categoriesInput
					$uploadButton
				</form>";
	}

	private function createFileInput() {

		return "<div class='form-group'>
    				<label for='fileInput!'>Your File</label>
    				<input type='file' class='form-control-file' id='fileInput' required name='fileInput'>
  				</div>";
	}

	private function createTitleInput($value) {

		if($value == null) $value = "";

		return "<div class='form-group'>
				<input class='form-control' type='text' placeholder='Title' name='titleInput' value='$value' autocomplete='off' required style='color: #ffffff;background-color:transparent;'>
				</div>";
	}

	private function createDescriptionInput($value) {

		if($value == null) $value = "";
		return "<div class='form-group'>
				<textarea class='form-control' placeholder='Description' name='descriptionInput' rows='3' autocomplete='off' style='color: #ffffff;background-color:transparent;'>$value</textarea>
				</div>";
	}

	private function createPrivacyInput($value) {
		if($value == null) $value = "";

		$privateSelected = ($value == 0) ? "selected='selected'" : "";
		$publicSelected = ($value == 1) ? "selected='selected'" : "";
		return "<div class='form-group'>
				<label for='privacyInput!'>Video Privacy Status</label>
				<select class='form-control' name='privacyInput' id='privacyInput!' required='true' >
  						<option value='0' $privateSelected>🛡️&nbsp;Private</option>
  						<option value='1' $publicSelected>🌐&nbsp;Public</option>
				</select>
				</div>";
	}

	private function createCategoriesInput($value) {
			if($value == null) $value = "";
			$query = $this->con->prepare("SELECT * FROM categories");
			$query->execute();
			$html = "<div class='form-group'>
						<label for='categoryInput!'>Category</label>
						<select class='form-control' name='categoryInput' id='categoryInput' required='true' style='color: #ffffff; background: rgb(18, 18, 18);'>";
			while($row = $query->fetch(PDO::FETCH_ASSOC)) {

				 $name = $row['name'];
				 $id = $row['id'];
				 $selected = ($id == $value) ? "selected='selected'" : "";

				 $html .= "<option $selected value='$id'>$name</option>";
			}

			$html .= "  </select>
				     </div>";
			return $html;	     
	}

	private function createUploadButton() {
		return "<button type='submit' class='btn btn-primary' name='uploadButton'>
				Proceed To Next Step
				</button>";
	}

	public function createEditDetailsForm($video) {
		$titleInput = $this->createTitleInput($video->getTitle());
		$updateTitleInBlockchainButton = "<button class='btn btn-primary' onclick='updateVideoTitle(); return false;'>Update title on the blockchain</button>";
		$descriptionInput = $this->createDescriptionInput($video->getDescription());
		$privacyInput = $this->createPrivacyInput($video->getPrivacy());
		$categoriesInput = $this->createCategoriesInput($video->getCategory());
		$saveButton = $this->createSaveButton();

		return "<form method='POST'>
					$titleInput
					$updateTitleInBlockchainButton <br><br>
					$descriptionInput
					$privacyInput
					$categoriesInput
					$saveButton
				</form>";
	}

	private function createSaveButton() {
		return "<button type='submit' class='btn btn-primary' name='saveButton'>
				Save
				</button>";
	}

	public function createReportForm() {
		$statement = "<p>Flagged videos are reviewed by DecenTube staff 24 hours a day, seven days a week to determine whether they violate any guidelines. If any guidelines are violated, then the video will be taken down. </p>";
		$videoUrlInput = $this->createVideoUrlInput();
		$reportCategoriesInput = $this->createReportCategoriesInput();
		$reportCommentsInput = $this->createReportCommentsInput();
		$reportButton = $this->createReportButton();

		return "<form method='POST'>
					$statement
					$videoUrlInput
					$reportCategoriesInput
					$reportCommentsInput
					$reportButton
				</form>";
	}

	private function createVideoUrlInput() {

		return "<div class='form-group'>
				<label for='videoUrlInput!'>Video URL</label>
				<input class='form-control' type='text' placeholder='URL of the video' name='videoUrlInput' autocomplete='off' required style='color: #ffffff;background-color:transparent;'>
				</div>";
	}

	private function createReportCategoriesInput() {
			return "<div class='form-group'>
						<label for='reportCategoryInput!'>Report Category</label>
						<select class='form-control' name='reportCategoryInput' id='reportCategoryInput' required='true' style='color: #ffffff; background: rgb(18, 18, 18);'>
							<option value='Violent or repulsive content'>Violent or repulsive content</option>
							<option value='Sexual content'>Sexual content</option>
							<option value='Harmful dangerous acts'>Harmful dangerous acts</option>
							<option value='Hateful or abusive content'>Hateful or abusive content</option>
							<option value='Promotes terrorism'>Promotes terrorism</option>
							<option value='Child abuse'>Child abuse</option>
							<option value='Spam or misleading'>Spam or misleading</option>
							<option value='Infringes my rights'>Infringes my rights</option>
						</select>
					</div>";
	}

	private function createReportCommentsInput() {
		return "<div class='form-group'>
				<label for='reportCommentsInput!'>Other complaints!</label>
				<textarea class='form-control' placeholder='Type your complaints here incase you have any more' name='reportCommentsInput' rows='3' autocomplete='off' style='color: #ffffff;background-color:transparent;'></textarea>
				</div>";
	}

	private function createReportButton() {
		return "<button type='submit' class='btn btn-primary' name='reportButton'>
				Submit report
				</button>";
	}


}

?>

