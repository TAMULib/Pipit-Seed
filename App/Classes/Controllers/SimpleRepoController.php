<?php
namespace App\Classes\Controllers;
use App\Classes\Data as AppClasses;
use Core\Classes as Core;

class SimpleRepoController extends Core\AbstractController {
	private $simpleRepo;

	protected function configure() {
		$this->simpleRepo = $this->getSite()->getDataRepository("SimpleRepoExample");

		$this->getPage()->setTitle("Manage Simple Repo Entries");
		$this->getPage()->setOptions(array(
								array("name"=>"list"),
								array("name"=>"add","action"=>"add","modal"=>true)));
		$this->getPage()->setIsSearchable(true);
	}

	protected function remove() {
		$data = $this->getSite()->getSanitizedInputData();
		if (isset($data['id']) && is_numeric($data['id']) && $this->simpleRepo->removeById($data['id'])) {
			$this->getSite()->addSystemMessage('Repo entry removed');
		} else {
			$this->getSite()->addSystemError('Error removing repo entry');
		}		
	}

	protected function insert() {
		$data = $this->getSite()->getSanitizedInputData();
		if (isset($data['entry']) && $this->simpleRepo->add($data['entry'])) {
			$this->getSite()->addSystemMessage('Repo entry added');
		} else {
			$this->getSite()->addSystemError('Error adding repo entry');
		}
	}

	protected function add() {
		$this->getPage()->setSubTitle('New Repo Entry');
		$this->setViewName('entries.add');
	}

	protected function update() {
		$data = $this->getSite()->getSanitizedInputData();
		if (isset($data['entry']) && (isset($data['id']) && is_numeric($data['id'])) && $this->simpleRepo->update($data['id'],$data['entry'])) {
			$this->getSite()->addSystemMessage('Entry updated');
		} else {
			$this->getSite()->addSystemError('Error updating entry');
		}
	}

	protected function edit() {
		$this->getPage()->setSubTitle('Update Entry');
		$data = $this->getSite()->getSanitizedInputData();
		if (isset($data['id']) && is_numeric($data['id']) && ($entry = $this->simpleRepo->getById($data['id']))) {
			$this->getSite()->getViewRenderer()->registerViewVariable("entry",$entry);
			$this->setViewName('entries.edit');
		}
	}

	protected function search() {
		$data = $this->getSite()->getSanitizedInputData();
		if (isset($data['term'])) {
			$this->getSite()->getViewRenderer()->registerViewVariable("entries",$this->simpleRepo->search($data['term']));
			$this->setViewName("entries.list");
		} else {
			$site->addSystemError('There was an error with the search');
		}
	}

	protected function loadDefault() {
		$this->getPage()->setSubTitle('Repo Entries');
		$this->getSite()->getViewRenderer()->registerViewVariable("entries", $this->simpleRepo->get());
		$this->setViewName('entries.list');
	}
}