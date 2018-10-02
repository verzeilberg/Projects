<?php

namespace Customers\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Customers\Entities\Customer;

class customerService implements customerServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of customers
     *
     * @return      array
     *
     */
    public function getCustomers() {

        $customers = $this->entityManager->getRepository(Customer::class)
                ->findBy([], ['dateCreated' => 'DESC']);

        return $customers;
    }

    /**
     *
     * Get customer object by on id
     *
     * @param       id  $id The id to fetch the customer from the database
     * @return      object
     *
     */
    public function getCustomer($id) {
        $customer = $this->entityManager->getRepository(Customer::class)
                ->findOneBy(['id' => $id], []);

        return $customer;
    }

    /**
     *
     * Get array of customers
     * @var $searchString string to search for
     *
     * @return      array
     *
     */
    public function searchCustomers($searchString) {
        $qb = $this->entityManager->getRepository(Customer::class)->createQueryBuilder('c');
        $qb->leftJoin('c.country', 'ctry');
        $orX = $qb->expr()->orX();
        $orX->add($qb->expr()->like('c.name', $qb->expr()->literal("%$searchString%")));
        $orX->add($qb->expr()->like('ctry.name', $qb->expr()->literal("%$searchString%")));
        $qb->where($orX);
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }

    /**
     *
     * Create form of an object
     *
     * @param       blog $event $customer
     * @return      form
     *
     */
    public function createForm($customer) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($customer);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Customers\Entity\Customer'));
        $form->bind($customer);

        return $form;
    }

    /**
     *
     * Create a new customer object
     * @return      object
     *
     */
    public function newCustomer() {
        $customer = new Customer();
        return $customer;
    }

    /**
     *
     * Save a customers to database
     * @param       customer $customer object
     * @param       user $user object
     * @return      void
     *
     */
    public function saveCustomer($customer, $user) {
        $customer->setDateCreated(new \DateTime());
        $customer->setCreatedBy($user);
        $this->storeCustomer($customer);
    }

    /**
     *
     * Update a customers to database
     * @param       customer $customer object
     * @param       user $user object
     * @return      void
     *
     */
    public function updateCustomer($customer, $user) {
        $customer->setDateChanged(new \DateTime());
        $customer->setChangedBy($user);
        $this->storeCustomer($customer);
    }

    /**
     *
     * Save a customer to database
     * @param       customer $customer object
     * @return      void
     *
     */
    public function storeCustomer($customer) {
        $this->entityManager->persist($customer);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a customer from database
     * @param       customer $customer object
     * @return      void
     *
     */
    public function deleteCustomer($customer) {
        $this->entityManager->remove($customer);
        $this->entityManager->flush();
    }

}
