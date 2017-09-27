<?php
namespace App\Classes\Data;
use Core\Classes\Data as CoreData;

/** 
 * Represents a file entry from the database
 *
 * @author Jason Savell <jsavell@library.tamu.edu>
 */
class DatabaseFile extends CoreData\SimpleFile {
	private $id;
	private $uploadDate;
	private $uploaderId;
	private $typeId;
	private $relatedId;

	public function __construct($fileName,$filePath,$fileType=null,$gloss=null,$id,$uploadDate,$uploaderId,$typeId,$relatedId) {
		parent::__construct($fileName,$filePath,$fileType,$gloss);
		$this->setId($id);
		$this->setUploadDate($uploadDate);
		$this->setUploaderId($uploaderId);
		$this->setTypeId($typeId);
		$this->setRelatedId($relatedId);
	}

	protected function setId($id) {
		$this->id = $id;
	}

	protected function setUploadDate($uploadDate) {
		$this->uploadDate = $uploadDate;
	}

	protected function setUploaderId($uploaderId) {
		$this->uploaderId = $uploaderId;
	}

	protected function setTypeId($typeId) {
		$this->typeId = $typeId;
	}

	protected function setRelatedId($relatedId) {
		$this->relatedId = $relatedId;
	}

	public function getId() {
		return $this->id;
	}

	public function getUploadDate() {
		return $this->uploadDate;
	}

	public function getUploaderId() {
		return $this->uploaderId;
	}

	public function getTypeId() {
		return $this->typeId;
	}

	public function getRelatedId() {
		return $this->relatedId;
	}

	public function getFullPath() {
		$fullPath = $this->getFilePath();
		if ($fullPath) {
			$fullPath .= '/';
		}
		return $fullPath.$this->getFileName();
	}
}