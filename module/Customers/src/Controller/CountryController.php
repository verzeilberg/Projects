<?php

namespace Customers\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class CountryController extends AbstractActionController {

    protected $vhm;
    protected $em;
    protected $cs;
    protected $ufs;
    protected $cropImageService;
    protected $imageService;

    public function __construct($vhm, $em, $cs, $ufs, $cropImageService, $imageService) {
        $this->vhm = $vhm;
        $this->em = $em;
        $this->cs = $cs;
        $this->ufs = $ufs;
        $this->cropImageService = $cropImageService;
        $this->imageService = $imageService;
    }

    public function indexAction() {
        $countries = $this->cs->getCountries();
        $searchString = '';
        if ($this->getRequest()->isPost()) {
            $searchString = $this->getRequest()->getPost('search');
            $countries = $this->cs->searchCountries($searchString);
        }

        return new ViewModel(
                array(
            'countries' => $countries,
            'searchString' => $searchString
                )
        );
    }

    public function addAction() {
        $this->vhm->get('headScript')->appendFile('/js/upload-files.js');
        $this->vhm->get('headLink')->appendStylesheet('/css/upload-image.css');
        //Create session container for crop images
        $container = new Container('cropImages');
        $container->getManager()->getStorage()->clear('cropImages');


        $country = $this->cs->newCountry();
        $form = $this->cs->createForm($country);

        //Create new image object and form for image
        $image = $this->imageService->createImage();
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
                    $imageFiles = $this->cropImageService->uploadImage($imageFile, 'default', 'original', $image, 1);

                    if (is_array($imageFiles)) {
                        $folderOriginal = $imageFiles['imageType']->getFolder();
                        $fileName = $imageFiles['imageType']->getFileName();
                        $image = $imageFiles['image'];
                        //Upload thumb 150x100
                        $imageFiles = $this->cropImageService->resizeAndCropImage('public/' . $folderOriginal . $fileName, 'public/img/userFiles/countries/thumb/', 150, 100, '150x100', $image);
                        //Create 450x300 crop
                        $imageFiles = $this->cropImageService->createCropArray('450x300', $folderOriginal, $fileName, 'public/img/userFiles/countries/450x300/', 450, 300, $image);
                        $image = $imageFiles['image'];
                        $cropImages = $imageFiles['cropImages'];
                        //Create return URL
                        $returnURL = $this->cropImageService->createReturnURL('beheer/countries', 'index');

                        //Create session container for crop
                        $this->cropImageService->createContainerImages($cropImages, $returnURL);

                        //Save blog image
                        $this->imageService->saveImage($image);
                        //Add imgae to country
                        $country->setCountryImage($image);
                    } else {
                        $this->flashMessenger()->addErrorMessage($imageFiles);
                    }
                } else {
                    $this->flashMessenger()->addErrorMessage('Image not uploaded');
                }
                //End upload image
                //Save Country
                $this->cs->saveCountry($country, $this->currentUser());

                if ($imageFile['error'] === 0 && is_array($imageFiles)) {
                    return $this->redirect()->toRoute('beheer/images', array('action' => 'crop'));
                } else {
                    return $this->redirect()->toRoute('beheer/countries');
                }
            }
        }

        return new ViewModel(
                array(
            'country' => $country,
            'form' => $form,
            'formImage' => $formImage
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
            return $this->redirect()->toRoute('beheer/countries');
        }
        $country = $this->cs->getCountry($id);
        if (empty($country)) {
            return $this->redirect()->toRoute('beheer/countries');
        }

        $image = $this->imageService->createImage();
        $formImage = $this->imageService->createImageForm($image);
        $form = $this->cs->createForm($country);

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
                    $imageFiles = $this->cropImageService->uploadImage($imageFile, 'default', 'original', $image, 1);
                    if (is_array($imageFiles)) {
                        $folderOriginal = $imageFiles['imageType']->getFolder();
                        $fileName = $imageFiles['imageType']->getFileName();
                        $image = $imageFiles['image'];
                        //Upload thumb 150x100
                        $imageFiles = $this->cropImageService->resizeAndCropImage('public/' . $folderOriginal . $fileName, 'public/img/userFiles/countries/thumb/', 150, 100, '150x100', $image);
                        //Create 450x300 crop
                        $imageFiles = $this->cropImageService->createCropArray('450x300', $folderOriginal, $fileName, 'public/img/userFiles/countries/450x300/', 450, 300, $image);
                        $image = $imageFiles['image'];
                        $cropImages = $imageFiles['cropImages'];
                        //Create return URL
                        $returnURL = $this->cropImageService->createReturnURL('beheer/countries', 'index');

                        //Create session container for crop
                        $this->cropImageService->createContainerImages($cropImages, $returnURL);

                        //Save blog image
                        $this->imageService->saveImage($image);
                        //Add image to country
                        $country->setCountryImage($image);
                    } else {
                        $this->flashMessenger()->addErrorMessage($imageFiles);
                    }
                } else {
                    $this->flashMessenger()->addErrorMessage('Image not uploaded');
                }
                //End upload image
                //Save Country
                $this->cs->updateCountry($country, $this->currentUser());

                if ($imageFile['error'] === 0 && is_array($imageFiles)) {
                    return $this->redirect()->toRoute('beheer/images', array('action' => 'crop'));
                } else {
                    return $this->redirect()->toRoute('beheer/countries');
                }
            }
        }

        $returnURL = $this->cropImageService->createReturnURL('beheer/countries', 'edit', $id);

        return new ViewModel(
                array(
            'country' => $country,
            'form' => $form,
            'formImage' => $formImage,
            'image' => $country->getCountryImage(),
            'returnURL' => $returnURL
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
        //Delete linked images
        $image = $country->getCountryImage();
        if (is_object($image)) {
            $this->imageService->deleteImage($image);
        }


        $this->cs->deleteCountry($country);
        $this->flashMessenger()->addSuccessMessage('Country removed');
        return $this->redirect()->toRoute('beheer/countries');
    }

}
