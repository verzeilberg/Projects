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
        $country = new Country();
        return $country;
    }

    /**
     *
     * Save a countries to database
     * @param       country $country object
     * @param       user $user object
     * @return      void
     *
     */
    public function saveCountry($country, $user) {
        $country->setDateCreated(new \DateTime());
        $country->setCreatedBy($user);
        $this->storeCountry($country);
    }

    /**
     *
     * Update a countries to database
     * @param       country $country object
     * @param       user $user object
     * @return      void
     *
     */
    public function updateCountry($country, $user) {
        $country->setDateChanged(new \DateTime());
        $country->setChangedBy($user);
        $this->storeCountry($country);
    }

    /**
     *
     * Save a countries to database
     * @param       countries $countries object
     * @return      void
     *
     */
    public function storeCountry($country) {
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
    public function deleteCountry($country) {
        $this->entityManager->remove($country);
        $this->entityManager->flush();
    }

}
