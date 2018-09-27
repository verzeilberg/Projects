<?php

namespace Customers\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Customers\Entities\Contact;

class contactService implements contactServiceInterface {

    private $entityManager;
    private $customerService;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $customerService) {
        $this->entityManager = $entityManager;
        $this->customerService = $customerService;
    }

    /**
     *
     * Get array of contacts
     *
     * @return      array
     *
     */
    public function getContacts() {

        $contacts = $this->entityManager->getRepository(Contact::class)
                ->findBy([], ['dateCreated' => 'DESC']);

        return $contacts;
    }
    
    /**
     *
     * Get array of contacts
     *
     * @return      array
     *
     */
    public function getContactsByCustomer($id) {
        $contacts = $this->entityManager->getRepository(Contact::class)
                ->findBy(['customer' => $id], ['dateCreated' => 'DESC']);

        return $contacts;
    }

    /**
     *
     * Get contact object by on id
     *
     * @param       id  $id The id to fetch the contact from the database
     * @return      object
     *
     */
    public function getContact($id) {
        $contact = $this->entityManager->getRepository(Contact::class)
                ->findOneBy(['id' => $id], []);

        return $contact;
    }

    /**
     *
     * Create form of an object
     *
     * @param       blog $event $contact
     * @return      form
     *
     */
    public function createForm($contact) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($contact);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Contacts\Entity\Contact'));
        $form->bind($contact);

        return $form;
    }

    /**
     *
     * Create a new contact object
     * @return      object
     *
     */
    public function newContact() {
        $contact = new Contact();
        return $contact;
    }

    /**
     *
     * Save a contacts to database
     * @param       contact $contact object
     * @param       user $user object
     * @return      void
     *
     */
    public function saveContact($contact, $user) {
        $contact->setDateCreated(new \DateTime());
        $contact->setCreatedBy($user);
        $this->storeContact($contact);
    }

    /**
     *
     * Update a contacts to database
     * @param       contact $contact object
     * @param       user $user object
     * @return      void
     *
     */
    public function updateContact($contact, $user) {
        $contact->setDateChanged(new \DateTime());
        $contact->setChangedBy($user);
        $this->storeContact($contact);
    }

    /**
     *
     * Create a contact object and save to database
     * @param       data $data array
     * @return      $contact object
     *
     */
    public function creatContactFromAjaxRequest($data) {
        $params = [];
        parse_str($data, $params);
        $contact = $this->newContact();

        foreach ($params AS $index => $param) {
            if ($index == 'customer') {
                $customer = $this->customerService->getCustomer($param);
                $function = 'set' . ucfirst($index);
                $contact->$function($customer);
            } else {
                $function = 'set' . ucfirst($index);
                $contact->$function($param);
            }
        }

        return $contact;
    }

    /**
     *
     * Save a contact to database
     * @param       contact $contact object
     * @return      void
     *
     */
    public function storeContact($contact) {
        $this->entityManager->persist($contact);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a contact from database
     * @param       contact $contact object
     * @return      void
     *
     */
    public function deleteContact($contact) {
        $this->entityManager->remove($contact);
        $this->entityManager->flush();
    }

}
