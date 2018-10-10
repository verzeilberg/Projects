<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;

class ContactController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $cs;
    protected $contactService;
    protected $imageService;
    protected $cropImageService;

    public function __construct($vhm, $em, $cs, $contactService, $imageService, $cropImageService) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->cs = $cs;
        $this->contactService = $contactService;
        $this->imageService = $imageService;
        $this->cropImageService = $cropImageService;
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
        $this->vhm->get('headScript')->appendFile('/js/upload-images.js');
        $this->vhm->get('headLink')->appendStylesheet('/css/upload-image.css');
        
        //Create session container for crop images
        $container = new Container('cropImages');
        $container->getManager()->getStorage()->clear('cropImages');

        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $contact = $this->contactService->getContact($id);
        if (empty($contact)) {
            return $this->redirect()->toRoute('beheer/customers');
        }

        $image = $contact->getContactImage();
        if (empty($image)) {
            $image = $this->imageService->createImage();
        }

        $form = $this->contactService->createForm($contact);
        $formImage = $this->imageService->createImageForm($image);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            $formImage->setData($this->getRequest()->getPost());
            if ($form->isValid() && $formImage->isValid()) {
                //Create image array and set it
                $imageFile = [];
                $imageFile = $this->getRequest()->getFiles('image');

                //Upload image
                if ($imageFile['error'] === 0) {
                    //Upload original file
                    $imageFiles = $this->cropImageService->uploadImage($imageFile, 'contact', 'original', $image, 1);
                    if (is_array($imageFiles)) {
                        $folderOriginal = $imageFiles['imageType']->getFolder();
                        $fileName = $imageFiles['imageType']->getFileName();
                        $image = $imageFiles['image'];
                        //Upload thumb 150x100
                        $imageFiles = $this->cropImageService->resizeAndCropImage('public/' . $folderOriginal . $fileName, 'public/img/userFiles/contacts/thumb/', 100, 50, '100x50', $image);
                        //Create 438x625 crop
                        $imageFiles = $this->cropImageService->createCropArray('438x625', $folderOriginal, $fileName, 'public/img/userFiles/contacts/438x625/', 438, 625, $image);
                        $image = $imageFiles['image'];
                        $cropImages = $imageFiles['cropImages'];
                        //Create return URL
                        $returnURL = $this->cropImageService->createReturnURL('beheer/contacts', 'edit', $id);

                        //Create session container for crop
                        $this->cropImageService->createContainerImages($cropImages, $returnURL);

                        //Save blog image
                        $this->imageService->saveImage($image);
                        //Add image to contact
                        $contact->setContactImage($image);
                    } else {
                        $this->flashMessenger()->addErrorMessage($imageFiles);
                    }
                } else {
                    $this->flashMessenger()->addErrorMessage('Image not uploaded');
                }
                //End upload image
                //Save Contact
                $this->contactService->updateContact($contact, $this->currentUser());

                if ($imageFile['error'] === 0 && is_array($imageFiles)) {
                    return $this->redirect()->toRoute('beheer/images', array('action' => 'crop'));
                } else {
                    return $this->redirect()->toRoute('beheer/contacts', ['action' => 'edit', 'id' => $id]);
                }
            }
        }

        //Create return url
        $returnURL = $this->cropImageService->createReturnURL('beheer/contacts', 'edit', $id);

        return new ViewModel(
                array(
            'form' => $form,
            'image' => $image,
            'formImage' => $formImage,
            'returnURL' => $returnURL,
            'customer' => $contact->getCustomer()
                )
        );
    }

    public function showAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $contact = $this->contactService->getContact($id);
        if (empty($contact)) {
            return $this->redirect()->toRoute('beheer/customers');
        }

        $image = $contact->getContactImage();

        return new ViewModel(
                array(
            'contact' => $contact,
            'image' => $image
                )
        );
    }

    /**
     * 
     * Action to delete the contact from the database
     */
    public function deleteAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (empty($id)) {
            return $this->redirect()->toRoute('beheer/customers');
        }
        $contact = $this->contactService->getContact($id);
        if (empty($contact)) {
            return $this->redirect()->toRoute('beheer/customers');
        }

        //Get customer ID for redirect
        $customerId = $contact->getCustomer()->getId();

        $this->contactService->deleteContact($contact);
        $this->flashMessenger()->addSuccessMessage('Contact removed');
        return $this->redirect()->toRoute('beheer/customers', ['action' => 'show', 'id' => $customerId]);
    }

}
