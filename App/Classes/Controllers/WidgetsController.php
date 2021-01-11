<?php
namespace App\Classes\Controllers;
use App\Classes\Data as AppClasses;
use Core\Classes as Core;

class WidgetsController extends Core\AbstractController {
    private $widgetsRepo;

    protected function configure() {
        $this->widgetsRepo = $this->getSite()->getDataRepository("Widgets");

        $this->getPage()->setTitle("Manage Widgets");
        $this->getPage()->setOptions(array(
                                array("name"=>"list"),
                                array("name"=>"add","action"=>"add","modal"=>true)));
        $this->getPage()->setIsSearchable(true);
    }

    protected function parts() {
        $data = $this->getSite()->getSanitizedInputData();
        $widget = $this->widgetsRepo->getById($data['widgetid']);
        $this->getPage()->setSubTitle('Parts for '.$widget['name']);
        $this->getSite()->getViewRenderer()->registerViewVariable("widget",$widget);
        $this->getSite()->getViewRenderer()->registerViewVariable("parts",$this->widgetsRepo->getPartsByWidgetId($data['widgetid']));
        $this->setViewName('widgets.parts');
    }

    protected function remove() {
        $data = $this->getSite()->getSanitizedInputData();
        if (isset($data['id']) && is_numeric($data['id']) && $this->widgetsRepo->removeById($data['id'])) {
            $this->getSite()->addSystemMessage('Widget removed');
        } else {
            $this->getSite()->addSystemError('Error removing widget');
        }
    }

    protected function insert() {
        $data = $this->getSite()->getSanitizedInputData();
        if (isset($data['widget']) && $this->widgetsRepo->add($data['widget'])) {
            $this->getSite()->addSystemMessage('Widget added');
        } else {
            $this->getSite()->addSystemError('Error adding widget');
        }
    }

    protected function add() {
        $this->getPage()->setSubTitle('New Widget');
        $this->setViewName('widgets.add');
    }

    protected function update() {
        $data = $this->getSite()->getSanitizedInputData();
        if (isset($data['widget']) && (isset($data['id']) && is_numeric($data['id'])) && $this->widgetsRepo->update($data['id'],$data['widget'])) {
            $this->getSite()->addSystemMessage('Widget updated');
        } else {
            $this->getSite()->addSystemError('Error updating widget');
        }
    }

    protected function edit() {
        $this->getPage()->setSubTitle('Update Widget');
        $data = $this->getSite()->getSanitizedInputData();
        if (isset($data['id']) && is_numeric($data['id']) && ($widget = $this->widgetsRepo->getById($data['id']))) {
            $this->getSite()->getViewRenderer()->registerViewVariable("widget",$widget);
            $this->setViewName('widgets.edit');
        }
    }

    protected function partsAdd() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($this->widgetsRepo->addPartToWidget($data['widgetid'],$data['part'])) {
            $this->getSite()->addSystemMessage('Part added');
        } else {
            $this->getSite()->addSystemError('There was an error adding the part');
        }
    }

    protected function partsRemove() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($this->widgetsRepo->removePartById($data['partid'])) {
            $this->getSite()->addSystemMessage('Part removed');
        } else {
            $this->getSite()->addSystemError('There was an error removing the part');
        }
    }

    protected function attachments() {
        $data = $this->getSite()->getSanitizedInputData();
        $this->getPage()->setSubTitle('Attachments');

        if ($data['widgetid']) {
            $widget = $this->widgetsRepo->getById($data['widgetid']);
            if (!$data['pageContext']) {
                $data['pageContext'] = null;
            }
            $this->getSite()->getViewRenderer()->registerViewVariable('pageContext', $data['pageContext']);
            $this->getSite()->getViewRenderer()->registerViewVariable('attachments',$this->getSite()->getDataRepository("Files")->getByRelatedIdAndType($widget['id'],1));
            $this->getSite()->getViewRenderer()->registerViewVariable('widget', $widget);
            $this->setViewName('widgets.attachments');
        }
    }

    protected function attachmentsDownload() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['attachmentid'] && ($file = $this->getSite()->getDataRepository("Files")->getById($data['attachmentid']))) {
            try {
                $this->getSite()->getHelper("FileManager")->getDownloadableFile($file);
            } catch (\RuntimeException $e) {
                $this->getLogger()->warn($e->getMessage());
                $this->getSite()->addSystemError('Could not find the file requested for download');
                $this->loadDefault();
            }
        }
    }

    protected function attachmentsAdd() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['newFile'] && $data['widgetid']) {
            $widget = $this->widgetsRepo->getById($data['widgetid']);
            $fileManager = $this->getSite()->getHelper("FileManager");
            $filesRepo = $this->getSite()->getDataRepository("Files");

            try {
                $filePath = 'attachments';
                $fileName = $fileManager->processBase64File($data['newFile'],null,$filePath);

                $fileType = '';
                $temp = explode('.',$data['fileGloss']);
                if (count($temp) > 1) {
                    $fileType = array_pop($temp);
                }

                //add file to files repo
                $filesRepo->add(array("name"=>$fileName,"path"=>$filePath,"file_type"=>$fileType,"gloss"=>$data['fileGloss'],"userid"=>$this->getSite()->getGlobalUser()->getProfileValue("id"),"typeid"=>1,"relatedid"=>$data['widgetid']));
            } catch (\RuntimeException $e) {
                $this->getLogger()->error($e->getMessage());
                http_response_code(500);
            }
        }
    }

    protected function attachmentsRemove() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['attachmentid']) {
            $fileManager = $this->getSite()->getHelper("FileManager");
            $filesRepo = $this->getSite()->getDataRepository("Files");
            if ($removableFile = $filesRepo->getById($data['attachmentid'])) {
                try {
                    $fileManager->removeFile($removableFile);
                    $filesRepo->removeById($data['attachmentid']);
                } catch (\RuntimeException $e) {
                    $this->getLogger()->warn($e->getMessage());
                    $this->getSite()->addSystemError('Error removing the attachment');
                }
            }
        }
    }

    protected function search() {
        $data = $this->getSite()->getSanitizedInputData();
        if (isset($data['term'])) {
            $this->getSite()->getViewRenderer()->registerViewVariable("widgets",$this->widgetsRepo->search($data['term']));
            $this->setViewName("widgets.list");
        } else {
            $this->getSite()->addSystemError('There was an error with the search');
        }
    }

    protected function loadDefault() {
        $this->getPage()->setSubTitle('Widgets');
        $this->getSite()->getViewRenderer()->registerViewVariable("widgets", $this->widgetsRepo->get());
        $this->setViewName('widgets.list');
    }
}
