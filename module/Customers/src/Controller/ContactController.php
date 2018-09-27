<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ContactController extends AbstractActionController {

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
        $contacts = $this->contactService->getContacts();

        return new ViewModel(
                array(
            'contacts' => $contacts
                )
        );
    }

    public function addAction() {
        $success = true;
        $errorMessage = '';
        if ($this->getRequest()->isPost()) {
            $contact = $this->contactService->creatContactFromAjaxRequest($this->getRequest()->getPost()['formData']);
            $this->contactService->saveContact($contact, $this->currentUser());
        } else {
            $success = false;
            $errorMessage = 'There was no post!';
        }
        return new JsonModel(
                array(
            'success' => $success,
            'errorMessage' => $errorMessage,
            'contact' => $contact
                )
        );
    }

    public function editAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $contact = $this->contactService->getContact($id);
        if (empty($contact)) {
            return $this->redirect()->toRoute('beheer/contacts');
        }
        $form = $this->contactService->createForm($contact);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());

            if ($form->isValid()) {
                //Save Contact
                $this->contactService->updateContact($contact, $this->currentUser());

                return $this->redirect()->toRoute('beheer/contacts');
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
     * Action to delete the contact from the database
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        $id2 = (int) $this->params()->fromRoute('id2', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers', ['action' => 'show', 'id' => $id2]);
        }
        $contact = $this->contactService->getContact($id);
        if (empty($contact)) {
            return $this->redirect()->toRoute('beheer/customers', ['action' => 'show', 'id' => $id2]);
        }

        $this->contactService->deleteContact($contact);
        $this->flashMessenger()->addSuccessMessage('Contact removed');
        return $this->redirect()->toRoute('beheer/customers', ['action' => 'show', 'id' => $id2]);
    }

}
