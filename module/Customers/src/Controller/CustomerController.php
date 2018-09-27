<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class CustomerController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $cs;
    protected $contactService;
    protected $imageService;

    public function __construct($vhm, $em, $cs, $contactService, $imageService) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->cs = $cs;
        $this->contactService = $contactService;
        $this->imageService = $imageService;
    }

    public function indexAction() {
        $customers = $this->cs->getCustomers();

        return new ViewModel(
                array(
            'customers' => $customers
                )
        );
    }

    public function addAction() {
        $customer = $this->cs->newCustomer();
        $form = $this->cs->createForm($customer);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->cs->saveCustomer($customer, $this->currentUser());

                return $this->redirect()->toRoute('beheer/customers');
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
            return $this->redirect()->toRoute('beheer/customers');
        }
        $customer = $this->cs->getCustomer($id);
        if (empty($customer)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $form = $this->cs->createForm($customer);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->cs->updateCustomer($customer, $this->currentUser());

                return $this->redirect()->toRoute('beheer/customers');
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
            return $this->redirect()->toRoute('beheer/customers');
        }
        $customer = $this->cs->getCustomer($id);
        if (empty($customer)) {
            return $this->redirect()->toRoute('beheer/customers');
        }

        $this->cs->deleteCustomer($customer);
        $this->flashMessenger()->addSuccessMessage('Customer removed');
        return $this->redirect()->toRoute('beheer/customers');
    }

    public function showAction() {
        $this->vhm->get('headScript')->appendFile('/js/upload-files.js');
        $this->vhm->get('headScript')->appendFile('/js/contact.js');
        $this->vhm->get('headLink')->appendStylesheet('/css/upload-image.css');

        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $customer = $this->cs->getCustomer($id);
        if (empty($customer)) {
            return $this->redirect()->toRoute('beheer/customers');
        }

        $contacts = $this->contactService->getContacts();
        $contact = $this->contactService->newContact();
        $form = $this->contactService->createForm($contact);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Customer
                $this->cs->updateCustomer($customer, $this->currentUser());

                return $this->redirect()->toRoute('beheer/customers');
            }
        }

        return new ViewModel(
                array(
            'customer' => $customer,
            'contacts' => $contacts,
            'form' => $form,
                )
        );
    }

}
