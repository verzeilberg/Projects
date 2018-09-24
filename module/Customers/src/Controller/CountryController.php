<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CountryController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $cs;
    protected $ufs;

    public function __construct($vhm, $em, $cs, $ufs) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->cs = $cs;
        $this->ufs = $ufs;
    }

    public function indexAction() {
        $countries = $this->cs->getCountries();

        return new ViewModel(
                array(
            'countries' => $countries
                )
        );
    }

    public function addAction() {
        $country = $this->cs->newCountry();
        $form = $this->cs->createForm($country);
        $form = $this->ufs->addFileInputToForm($form);
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                if ($this->getRequest()->getFiles('fileUpload') != null) {
                    $data = $this->ufs->uploadFile($this->getRequest()->getFiles('fileUpload'), null, 'default');

                    if (is_array($data)) {
                        $file = $this->ufs->createFile();
                        $description = $this->getRequest()->getPost('fileDescription');
                        $this->ufs->setNewFile($file, $data, $description, $this->currentUser());
                        $country->setFlag($file);
                    } else {
                        $this->flashMessenger()->addErrorMessage('Flag not saved: ' . $data);
                    }
                }

                //Save Event
                $country->setDateCreated(new \DateTime());
                $this->cs->saveCountry($country, $this->currentUser());
                $this->flashMessenger()->addSuccessMessage('Country saved');
                return $this->redirect()->toRoute('beheer/countries');
            }
        }

        return new ViewModel(
                array(
            'country' => $country,
            'form' => $form
                )
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/countries');
        }
        $country = $this->cs->getCountry($id);
        if (empty($country)) {
            return $this->redirect()->toRoute('beheer/countries');
        }
        $form = $this->cs->createForm($country);
        $form = $this->ufs->addFileInputToForm($form);
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {

                if ($this->getRequest()->getFiles('fileUpload') != null) {
                    $data = $this->ufs->uploadFile($this->getRequest()->getFiles('fileUpload'), null, 'default');

                    if (is_array($data)) {
                        $file = $this->ufs->createFile();
                        $description = $this->getRequest()->getPost('fileDescription');
                        $this->ufs->setNewFile($file, $data, $description, $this->currentUser());
                        $country->setFlag($file);
                    } else {
                        $this->flashMessenger()->addErrorMessage('Flag not saved: ' . $data);
                    }
                }

                //Save Event
                $country->setDateCreated(new \DateTime());
                $this->cs->saveCountry($country, $this->currentUser());
                $this->flashMessenger()->addSuccessMessage('Country edited');
                return $this->redirect()->toRoute('beheer/countries');
            }
        }

        return new ViewModel(
                array(
            'country' => $country,
            'form' => $form
                )
        );
    }

    /**
     * 
     * Action to delete the country from the database and linked images
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/countries');
        }
        $country = $this->cs->getCountry($id);
        if (empty($country)) {
            return $this->redirect()->toRoute('beheer/countries');
        }
        //Delete country and file
        $file = $country->getFlag();
        if (count($file) > 0) {
            $this->ufs->deleteFile($file);
        }
        
        $this->cs->deleteCountry($country);
        $this->flashMessenger()->addSuccessMessage('Country removed');
        return $this->redirect()->toRoute('beheer/countries');
    }

}
