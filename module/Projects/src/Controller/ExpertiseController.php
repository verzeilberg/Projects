<?php

namespace Projects\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ExpertiseController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $serviceManager;

    public function __construct($vhm, $em, $serviceManager) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->serviceManager = $serviceManager;
    }

    public function indexAction() {
        $items = $this->serviceManager->getExpertises();

        return new ViewModel(
                array(
            'items' => $items
                )
        );
    }

    public function addAction() {
        $expertise = $this->serviceManager->newExpertise();
        $form = $this->serviceManager->createForm($expertise);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) { 
                //Save Customer
                $this->serviceManager->saveExpertise($expertise);

                return $this->redirect()->toRoute('beheer/expertises');
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
            return $this->redirect()->toRoute('beheer/expertises');
        }
        $expertise = $this->serviceManager->getExpertise($id);
        if (empty($expertise)) {
            return $this->redirect()->toRoute('beheer/expertises');
        }
        $form = $this->serviceManager->createForm($expertise);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->serviceManager->saveExpertise($expertise);

                return $this->redirect()->toRoute('beheer/expertises');
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
     * Action to delete the expertise item from the database
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/expertises');
        }
        $expertise = $this->serviceManager->getExpertise($id);
        if (empty($expertise)) {
            return $this->redirect()->toRoute('beheer/expertises');
        }

        $this->serviceManager->deleteExpertise($expertise);
        $this->flashMessenger()->addSuccessMessage('Expertise removed');
        return $this->redirect()->toRoute('beheer/expertises');
    }

}
