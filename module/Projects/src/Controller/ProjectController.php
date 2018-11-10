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

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->ps->saveProject($project);

                return $this->redirect()->toRoute('beheer/projects');
            }
        }

        return new ViewModel(
                array(
            'form' => $form
                )
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/projects');
        }
        $project = $this->ps->getProject($id);
        if (empty($project)) {
            return $this->redirect()->toRoute('beheer/projects');
        }
        $form = $this->ps->createForm($project);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->ps->saveProject($project);

                return $this->redirect()->toRoute('beheer/projects');
            }
        }

        return new ViewModel(
                array(
            'form' => $form
                )
        );
    }

    /**
     * 
     * Action to delete the customer from the database
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/projects');
        }
        $project = $this->ps->getProject($id);
        if (empty($project)) {
            return $this->redirect()->toRoute('beheer/projects');
        }

        $this->ps->deleteProject($project);
        $this->flashMessenger()->addSuccessMessage('Project removed');
        return $this->redirect()->toRoute('beheer/projects');
    }

}
