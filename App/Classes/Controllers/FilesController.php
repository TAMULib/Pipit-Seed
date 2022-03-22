<?php
namespace App\Classes\Controllers;
use App\Classes\Data as AppClasses;
use Core\Classes as Core;

class FilesController extends Core\AbstractController {
    private $fileManager;

    public function configure() {
        $this->fileManager = $this->getSite()->getHelper("FileManager");
    }

    protected function upload() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['newFile']) {
            try {
                $fileName = $this->fileManager->processBase64File($data['newFile'],$data['fileGloss']);

                $fileType = '';
                $temp = explode('.',$data['gloss']);
                if (count($temp) > 1) {
                    $fileType = array_pop($temp);
                }
            } catch (\RuntimeException $e) {
                $this->getLogger()->error($e->getMessage());
                http_response_code(500);
            }
        }
    }

    protected function download() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['fileName']) {
            $this->fileManager->getDownloadableFileByFileName($data['fileName']);
        }
    }

    protected function remove() {
        $data = $this->getSite()->getSanitizedInputData();
        if ($data['fileName']) {
            try {
                $this->fileManager->removeFileByFileName($data['fileName']);
            } catch (\RuntimeException $e) {
                $this->getLogger()->error($e->getMessage());
                $this->getSite()->addSystemError('There was an error reamoving this file: '.$data['fileName']);
            }
        }
    }

    protected function loadDefault() {
        $this->getPage()->setSubTitle('Files');
        try {
            $files = $this->fileManager->getDirectoryFiles();
            $this->getSite()->getViewRenderer()->registerViewVariable("scanned_directory",$this->fileManager->getBaseFilePath());
            $this->getSite()->getViewRenderer()->registerViewVariable("files",$files);
        } catch (\RuntimeException $e) {
            $this->getLogger()->warn($e->getMessage());
            $this->getSite()->addSystemError('There was an error reading the contents of the upload directory');
        }
        $this->setViewName('files');
    }
}
