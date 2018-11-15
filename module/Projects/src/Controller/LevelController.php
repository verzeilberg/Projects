<?php

namespace Projects\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LevelController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $serviceManager;

    public function __construct($vhm, $em, $serviceManager) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->serviceManager = $serviceManager;
    }

    public function indexAction() {
        $items = $this->serviceManager->getLevels();

        return new ViewModel(
                array(
            'items' => $items
                )
        );
    }

    public function addAction() {
        $level = $this->serviceManager->newLevel();
        $form = $this->serviceManager->createForm($level);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) { 
                //Save Customer
                $this->serviceManager->saveLevel($level);

                return $this->redirect()->toRoute('beheer/levels');
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
            return $this->redirect()->toRoute('beheer/levels');
        }
        $level = $this->serviceManager->getLevel($id);
        if (empty($level)) {
            return $this->redirect()->toRoute('beheer/levels');
        }
        $form = $this->serviceManager->createForm($level);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->serviceManager->saveLevel($level);

                return $this->redirect()->toRoute('beheer/levels');
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
            return $this->redirect()->toRoute('beheer/levels');
        }
        $level = $this->serviceManager->getLevel($id);
        if (empty($level)) {
            return $this->redirect()->toRoute('beheer/levels');
        }

        $this->serviceManager->deleteLevel($level);
        $this->flashMessenger()->addSuccessMessage('Level removed');
        return $this->redirect()->toRoute('beheer/levels');
    }

}
