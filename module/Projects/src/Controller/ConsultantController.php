<?php

namespace Projects\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ConsultantController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $serviceManager;
    protected $expertiseManager;
    protected $levelManager;
    protected $expertiseLevelManager;

    public function __construct($vhm, $em, $serviceManager, $expertiseManager, $levelManager, $expertiseLevelManager) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->serviceManager = $serviceManager;
        $this->expertiseManager = $expertiseManager;
        $this->levelManager = $levelManager;
        $this->expertiseLevelManager = $expertiseLevelManager;
    }

    public function indexAction() {
        $items = $this->serviceManager->getConsultants();

        return new ViewModel(
                array(
            'items' => $items
                )
        );
    }

    public function addAction() {
        $consultant = $this->serviceManager->newConsultant();
        $expertises = $this->expertiseManager->getExpertises();
        $levels = $this->levelManager->getLevels();
        $form = $this->serviceManager->createForm($consultant);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->serviceManager->saveConsultant($consultant);
                //Get selected expertise
                $expertises = $this->getRequest()->getPost('expertise');
                if (count($expertises) > 0) {
                    $expertiseLevelItems = $this->expertiseManager->getExpertisesByIds($expertises);

                    foreach ($expertiseLevelItems AS $item) {
                        $levelId = $this->getRequest()->getPost($item->getId() . '-expertiseLevel');
                        $level = $this->levelManager->getLevel($levelId);
                        //Save Expertise level
                        $expertiseLevel = $this->expertiseLevelManager->newExpertiseLevel();
                        $expertiseLevel->setConsultant($consultant);
                        $expertiseLevel->setExpertise($item);
                        $expertiseLevel->setLevel($level);
                        $this->expertiseLevelManager->saveExpertiseLevel($expertiseLevel);
                    }
                }
                return $this->redirect()->toRoute('beheer/consultants');
            }
        }
        return new ViewModel(
                array(
            'form' => $form,
            'expertises' => $expertises,
            'levels' => $levels
                )
        );
    }

    public function editAction() {


        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/consultants');
        }
        $consultant = $this->serviceManager->getConsultant($id);
        if (empty($consultant)) {
            return $this->redirect()->toRoute('beheer/consultants');
        }
        
        $expertiseLevels = $this->expertiseLevelManager->getExpertiseLevelsByConsultant($consultant->getId());
        
        $expertises = $this->expertiseManager->getExpertises();
        $levels = $this->levelManager->getLevels();
        $form = $this->serviceManager->createForm($consultant);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                //Save Customer
                $this->serviceManager->saveConsultant($consultant);
                //Get selected expertise
                $expertises = $this->getRequest()->getPost('expertise');
                if (count($expertises) > 0) {
                    $expertiseLevelItems = $this->expertiseManager->getExpertisesByIds($expertises);

                    foreach ($expertiseLevelItems AS $item) {
                        $levelId = $this->getRequest()->getPost($item->getId() . '-expertiseLevel');
                        $level = $this->levelManager->getLevel($levelId);
                        //Save Expertise level
                        $expertiseLevel = $this->expertiseLevelManager->newExpertiseLevel();
                        $expertiseLevel->setConsultant($consultant);
                        $expertiseLevel->setExpertise($item);
                        $expertiseLevel->setLevel($level);
                        $this->expertiseLevelManager->saveExpertiseLevel($expertiseLevel);
                    }
                }
                return $this->redirect()->toRoute('beheer/consultants');
            }
        }

        return new ViewModel(
                array(
            'form' => $form,
            'expertiseLevels' => $expertiseLevels,
            'expertises' => $expertises,
            'levels' => $levels
                )
        );
    }

    /**
     * 
     * Action to delete the consultant item from the database
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/consultants');
        }
        $consultant = $this->serviceManager->getConsultant($id);
        if (empty($consultant)) {
            return $this->redirect()->toRoute('beheer/consultants');
        }

        $this->serviceManager->deleteConsultant($consultant);
        $this->flashMessenger()->addSuccessMessage('Consultant removed');
        return $this->redirect()->toRoute('beheer/consultants');
    }

}
