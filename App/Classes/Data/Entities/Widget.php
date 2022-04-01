<?php
namespace App\Classes\Data\Entities;
use \Pipit\Interfaces\Entity;

class Widget implements Entity {
    private $id;
    private $name;
    private $partCount;
    private $description;

    private const DATA_MAP = 
        [
            "id"=>"setId",
            "name"=>"setName",
            "description"=> "setDescription",
            "part_count"=>"setPartCount"
        ];

    private function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPartCount() {
        return $this->partCount;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPartCount($partCount) {
        $this->partCount = $partCount;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public static function buildEntity() {
        return function($data) {
            $widget = new Widget();
            foreach ($data as $key=>$value) {
                if (array_key_exists($key,self::DATA_MAP)) {
                    $methodName = self::DATA_MAP[$key];
                    if (method_exists($widget, $methodName)) {
                        $widget->$methodName($value);
                    }
                }
            }
            return $widget;
        };
    }
}
