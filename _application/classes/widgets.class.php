<?php
class widgets extends dbobject {

	public function __construct() {
		$this->primaryTable = 'widgets';
		parent::__construct();
	}

	public function getWidgets() {
		$sql = "SELECT * FROM `widgets` ORDER BY `name`";
		return $this->queryWithIndex($sql,"id");
	}

	public function searchWidgetsBasic($term) {
		$sql = "SELECT * FROM `{$this->primaryTable}` WHERE 
				`name` LIKE ?";
		$bindparams = array("%".$term."%");
		if ($result = $this->executeQuery($sql,$bindparams)) {
			return $result;
		}
		return false;
	}

	public function getWidgetById($id) {
		$sql = "SELECT * FROM `{$this->primaryTable}` WHERE id=:id";
		$temp = $this->executeQuery($sql,array(":id"=>$id));
		return $temp[0];
	}

	public function removeWidget($id) {
		$sql = "DELETE FROM `{$this->primaryTable}` WHERE id=:id";
		return $this->executeUpdate($sql,array(":id"=>$id));
	}

	public function insertWidget($data) {
		return $this->buildInsertStatement($data);
	}

	public function updateWidget($id,$data) {
		return $this->buildUpdateStatement($id,$data);
	}
}