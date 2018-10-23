<?php

namespace Projects\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectTypeController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $projectTypeService;

    public function __construct($vhm, $em, $projectTypeService) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->projectTypeService = $projectTypeService;
    }

    public function indexAction() {
        $projectTypes = $this->projectTypeService->getProjectTypes();

        return new ViewModel(
                array(
            'projectTypes' => $projectTypes
                )
        );
    }

    public function addAction() {
        $projectType = $this->projectTypeService->newProjectType();
        $form = $this->projectTypeService->createForm($projectType);

        return new ViewModel(
                array(
            'form' => $form
                )
        );
    }

}
