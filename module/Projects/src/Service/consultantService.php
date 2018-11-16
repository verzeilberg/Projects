<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\Consultant;

class consultantService implements consultantServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of consultants
     *
     * @return      array
     *
     */
    public function getConsultants() {

        $consultants = $this->entityManager->getRepository(Consultant::class)
                ->findBy(
                    ['deletedAt' => null]
                );

        return $consultants;
    }

    /**
     *
     * Get consultant object by on id
     *
     * @param       id  $id The id to fetch the consultant from the database
     * @return      object
     *
     */
    public function getConsultant($id) {
        $consultant = $this->entityManager->getRepository(Consultant::class)
                ->findOneBy(['id' => $id], []);

        return $consultant;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $consultant
     * @return      form
     *
     */
    public function createForm($consultant) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($consultant);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Consultants\Entity\Consultant'));
        $form->bind($consultant);

        return $form;
    }

    /**
     *
     * Create a new consultant object
     * @return      object
     *
     */
    public function newConsultant() {
        $consultant = new Consultant();
        return $consultant;
    }

    /**
     *
     * Save a consultant to database
     * @param       consultant $consultant object
     * @return      void
     *
     */
    public function saveConsultant($consultant) {
        $this->entityManager->persist($consultant);
        $this->entityManager->flush();
    }
    
    /**
     *
     * Delete a consultant from database
     * @param       consultant $consultant object
     * @return      void
     *
     */
    public function deleteConsultant($consultant) {
        $this->entityManager->remove($consultant);
        $this->entityManager->flush();
    }

}
