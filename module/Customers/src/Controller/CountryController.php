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

}
