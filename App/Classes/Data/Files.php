<?php
namespace App\Classes\Data;
use Pipit\Classes\Data\AbstractDataBaseRepository;
use App\Classes\Helpers as Helpers;

/**
 * Repo for managing Files
 *
 * @author Jason Savell <jsavell@library.tamu.edu>
 */
class Files extends AbstractDataBaseRepository {
    private $fileManager;

    public function __construct() {
        parent::__construct('files','id','uploaded');
    }

    private function getBaseSql() {
        return "SELECT f.*,ft.name AS type_name,u.username,u.name_first,u.name_last FROM {$this->primaryTable} f
                LEFT JOIN files_types ft ON f.id=f.typeid
                LEFT JOIN users u ON f.userid=u.id";
    }

    private function getOrderedQueryResults($sql,$bindparams=null) {
        if ($this->defaultOrderBy) {
            $sql .= " ORDER BY {$this->defaultOrderBy}";
        }

        $fileRows = $this->queryWithIndex($sql,$this->primaryKey,null,$bindparams);
        if ($fileRows) {
            $fileRows = array_map(array($this,'processUserData'),$fileRows);
            return $this->getFileInstances($fileRows);
        }
        return $fileRows;
    }

    private function processUserData($fileData) {
        $userKeys = array('userid','username','name_last','name_first');
        $userData = array();
        foreach ($userKeys as $key) {
            $userData[$key] = $fileData[$key];
            unset($fileData[$key]);
        }
        $fileData['userData'] = $userData;
        return $fileData;
    }

    public function get() {
        return $this->getOrderedQueryResults($this->getBaseSql());
    }

    public function getById($id) {
        $sql = $this->getBaseSql()." WHERE f.{$this->primaryKey}=:id";
        $temp = $this->executeQuery($sql,array(":id"=>$id));
        if (!$temp[0]) {
            return false;
        }
        return $this->getFileInstance($this->processUserData($temp[0]));
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
        return new DatabaseFile($data['name'],$data['path'],$data['file_type'],$data['gloss'],$data['id'],$data['uploaded'],$data['userData'],$data['typeid'],$data['type_name'],$data['relatedid']);
    }

    private function getFileInstances($fileRows) {
        $files = array();
        foreach ($fileRows as $fileRow) {
            $files[] = $this->getFileInstance($fileRow);
        }
        return $files;
    }
}
