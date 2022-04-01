<?php
namespace App\Classes\Data;
use Pipit\Classes\Data\AbstractPageableDataBaseRepository;

class Widgets extends AbstractPageableDataBaseRepository {
	public function __construct() {
		parent::__construct('widgets','id','name',null,array("name"),5);
	}

    public function getPartsByWidgetId($widgetId) {
        $sql = "SELECT * FROM {$this->primaryTable}_parts WHERE widgetid=:widgetid";
        return $this->queryWithIndex($sql,'id',NULL,array("widgetid"=>$widgetId));
    }

    public function addPartToWidget($widgetId,$part) {
        $part['widgetid'] = $widgetId;
        return $this->buildInsertStatement($part,"{$this->primaryTable}_parts");
    }

    public function removePartById($partId) {
        $sql = "DELETE FROM {$this->primaryTable}_parts WHERE id=:partid";
        return $this->executeUpdate($sql,array(":partid"=>$partId));
    }
}
