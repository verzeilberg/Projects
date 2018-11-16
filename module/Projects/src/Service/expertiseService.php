<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\Expertise;

class expertiseService implements expertiseServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of expertises
     *
     * @return      array
     *
     */
    public function getExpertises() {

        $expertises = $this->entityManager->getRepository(Expertise::class)
                ->findBy(
                    ['deletedAt' => null]
                );

        return $expertises;
    }

    /**
     *
     * Get expertise object by on id
     *
     * @param       id  $id The id to fetch the expertise from the database
     * @return      object
     *
     */
    public function getExpertise($id) {
        $expertise = $this->entityManager->getRepository(Expertise::class)
                ->findOneBy(['id' => $id], []);

        return $expertise;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $expertise
     * @return      form
     *
     */
    public function createForm($expertise) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($expertise);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Expertises\Entity\Expertise'));
        $form->bind($expertise);

        return $form;
    }

    /**
     *
     * Create a new expertise object
     * @return      object
     *
     */
    public function newExpertise() {
        $expertise = new Expertise();
        return $expertise;
    }

    /**
     *
     * Save a expertise to database
     * @param       expertise $expertise object
     * @return      void
     *
     */
    public function saveExpertise($expertise) {
        $this->entityManager->persist($expertise);
        $this->entityManager->flush();
    }
    
    /**
     *
     * Delete a expertise from database
     * @param       expertise $expertise object
     * @return      void
     *
     */
    public function deleteExpertise($expertise) {
        $this->entityManager->remove($expertise);
        $this->entityManager->flush();
    }

}
