<?php

namespace View;

class ToPictureItView {

	private static $pictureURL = 'ToPictureItView::PictureURL';
	private static $description = 'ToPictureItView::Description';
	private static $pictureTag = 'ToPictureItView::PictureTag';

	private static $addPicture = 'ToPictureItView::AddPicture';
	private static $removePicture = 'ToPictureItView::RemovePicture';
	private static $hiddenClick = 'ToPictureItView::HiddenClick';

	private static $messageDetails = "";

	private static $rowURL = 'pictureurl';
	private static $rowDesc = 'description';
	private static $rowTag = 'tag';
	private static $rowID = 'id';
	
	private $pictureItList = '';
	
	public function response() : string {
		$response = $this->getHTMLContents();
		
		return $response;
	}
	
	public function userWantsToAddPicture() : bool {
		return isset($_POST[self::$addPicture]);
	}

	public function userWantsToRemovePicture() : bool {
		return isset($_POST[self::$removePicture]);
	}

	public function removalID() : string {
		return $_POST[self::$hiddenClick];
	}

	public function pageReloader() : void {
		header("Location: /");
	}

	public function allMessages(string $message) : void {
		self::$messageDetails = $message;		
	}

	public function getPictureUrl() : \Model\PictureURL {
		return new \Model\PictureURL($_POST[self::$pictureURL]);
	}

	public function getDescription() : \Model\PictureDescription {
		return new \Model\PictureDescription($_POST[self::$description]);
    }
    
    public function getPictureTag() : \Model\PictureTag {
        return new \Model\PictureTag($_POST[self::$pictureTag]);
	}
	
	public function getPictureItsList($list) : string {
		$this->pictureItList = '
		<table>
			<thead>
				<tr>
					<th>Picture</th>
					<th>Description</th>
					<th>Tag</th>
					<th>Action</th>
				</tr>
			</thead>
		';
		foreach ($list as $row) {
			$this->pictureItList .= '
			<br>
			<tr>
				<td class="TPIImg"><img src="' . $row[self::$rowURL] . '" alt="' . $row[self::$rowTag] . '"></td>
				<td class="TPIDesc">' . $row[self::$rowDesc] . '</td>
				<td class="TPITag">' . $row[self::$rowTag] . '</td>
				<td class="TPIDel">
				' . $this->generateRemoveButtonHTML($row[self::$rowID]) . '
				</td>
			</tr>
			';
		}

		$this->pictureItList .= '</table>';
		
		return $this->pictureItList;
	}

	private function generateRemoveButtonHTML($ID) : string {
		return '
			<form method="post" >
			<input type="hidden" name="' . self::$hiddenClick . '" value="' . $ID . '"/>
			<input type="submit" name="' . self::$removePicture . '" value="Remove" />	
			</form>
		';
	}

	private function generatePictureFormHTML() : string {
		return '
		  <h2>ToPictureIt</h2>
			<form method="post" > 
				<fieldset>
					<legend>ToPictureIt</legend>
					<p>' . self::$messageDetails . '</p>
					
					<label for="' . self::$pictureURL . '">Picture URL :</label>
					<input type="text" name="' . self::$pictureURL . '" />

					<label for="' . self::$description . '">Description :</label>
                    <input type="text" name="' . self::$description . '" />
                    
					<label for="' . self::$pictureTag . '">Picture Tag :</label>
					<input type="text" name="' . self::$pictureTag . '" />

					<input type="submit" name="' . self::$addPicture . '" value="Add ToPictureIt" />
				</fieldset>
			</form>
		';
	}
		
	private function getHTMLContents() : string {
		return '
		' . $this->generatePictureFormHTML() . '
		' . $this->pictureItList . '
		';
	}

}