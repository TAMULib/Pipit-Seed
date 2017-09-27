<?php
namespace App\Classes\Data;
use Core\Classes\Data as CoreData;
use App\Classes\Helpers as Helpers;

/** 
 * Repo for managing Files
 *
 * @author Jason Savell <jsavell@library.tamu.edu>
 */

class Files extends CoreData\AbstractDataBaseRepository {
	private $fileManager;

	public function __construct() {
		parent::__construct('files','id','uploaded');
	}

	private function getBaseSql() {
		return "SELECT f.*,ft.name AS type_name FROM {$this->primaryTable} f
				LEFT JOIN files_types ft ON f.id=f.typeid";
	}

	private function getOrderedQueryResults($sql,$bindparams=null) {
		if ($this->defaultOrderBy) {
			$sql .= " ORDER BY {$this->defaultOrderBy}";
		}

		$fileRows = $this->queryWithIndex($sql,$this->primaryKey,null,$bindparams);

		if ($fileRows) {
			return $this->getFileInstances($fileRows);
		}
		return $fileRows;
	}

	public function get() {
		return $this->getOrderedQueryResults($this->getBaseSql());
	}

	public function getById($id) {
		if (!($fileData = parent::getById($id))) {
			return false;
		}
		return $this->getFileInstance($fileData);
	}

	public function getByRelatedIdAndType($relatedId,$typeId) {
		return $this->getOrderedQueryResults($this->getBaseSql()." WHERE f.typeid=:typeid AND f.relatedid=:relatedid",array(":relatedid"=>$relatedId,":typeid"=>$typeId));

	}

	protected function getFileManager() {
		if (!$this->fileManager) {
			$this->fileManager = $this->getSite()->getHelper("FileManager");
		}
		return $this->fileManager;
	}

	public function getUploadPath() {
		return $this->getFileManager()->getBaseFilePath();
	}

	private function getFileInstance($data) {
		return new DatabaseFile($data['name'],$data['path'],$data['file_type'],$data['gloss'],$data['id'],$data['uploaded'],$data['userid'],$data['typeid'],$data['type_name'],$data['relatedid']);
	}

	private function getFileInstances($fileRows) {
		$files = array();
		foreach ($fileRows as $fileRow) {
			$files[] = $this->getFileInstance($fileRow);
		}
		return $files;
	}
}