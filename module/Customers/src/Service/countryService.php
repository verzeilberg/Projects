<?php

namespace Customers\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Customers\Entities\Country;

class countryService implements countryServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of countriess
     *
     * @return      array
     *
     */
    public function getCountries() {

        $countriess = $this->entityManager->getRepository(Country::class)
                ->findBy([], ['dateCreated' => 'DESC']);

        return $countriess;
    }

    /**
     *
     * Get countries object by on id
     *
     * @param       id  $id The id to fetch the countries from the database
     * @return      object
     *
     */
    public function getCountry($id) {
        $countries = $this->entityManager->getRepository(Country::class)
                ->findOneBy(['id' => $id], []);

        return $countries;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $countries
     * @return      form
     *
     */
    public function createForm($countries) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($countries);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Customers\Entity\Country'));
        $form->bind($countries);

        return $form;
    }

    /**
     *
     * Create a new countries object
     * @return      object
     *
     */
    public function newCountry() {
        $countries = new Country();
        return $countries;
    }

    /**
     *
     * Save a countries to database
     * @param       countries $countries object
     * @return      void
     *
     */
    public function saveCountry($country) {
        $this->entityManager->persist($country);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a countries from database
     * @param       countries $countries object
     * @return      void
     *
     */
    public function deleteCountry($countries) {
        $this->entityManager->remove($countries);
        $this->entityManager->flush();
    }

}
