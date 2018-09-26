<?php

namespace Projects\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProjectController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $ps;

    public function __construct($vhm, $em, $ps) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->ps = $ps;
    }

    public function indexAction() {
        $projects = $this->ps->getProjects();

        return new ViewModel(
                array(
            'projects' => $projects
                )
        );
    }

    public function addAction() {
        $project = $this->ps->newProject();
        $form = $this->ps->createForm($project);

        return new ViewModel(
                array(
            'form' => $form
                )
        );
    }

}
