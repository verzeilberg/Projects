<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\ExpertiseLevel;

class expertiseLevelService implements expertiseLevelServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of expertiseLevels
     *
     * @return      array
     *
     */
    public function getExpertiseLevels() {

        $expertiseLevels = $this->entityManager->getRepository(ExpertiseLevel::class)
                ->findBy(
                    ['deletedAt' => null]
                );

        return $expertiseLevels;
    }

    /**
     *
     * Get expertiseLevel object by on id
     *
     * @param       id  $id The id to fetch the expertiseLevel from the database
     * @return      object
     *
     */
    public function getExpertiseLevel($id) {
        $expertiseLevel = $this->entityManager->getRepository(ExpertiseLevel::class)
                ->findOneBy(['id' => $id], []);

        return $expertiseLevel;
    }
    
    public function getExpertiseLevelsByConsultant($consultantId) {
        $qb = $this->entityManager->getRepository(ExpertiseLevel::class)->createQueryBuilder('e');
        $qb->where('e.consultant = :consultantId');
        $qb->setParameter('consultantId', $consultantId);
        $query = $qb->getQuery();
        $result = $query->getResult();
        
        $expertiseLevels = [];
        foreach($result AS $item) {
            $expertiseLevels[$item->getExpertise()->getId()] = $item->getLevel()->getId();
        }
        return $expertiseLevels;
        
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $expertiseLevel
     * @return      form
     *
     */
    public function createForm($expertiseLevel) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($expertiseLevel);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'ExpertiseLevels\Entity\ExpertiseLevel'));
        $form->bind($expertiseLevel);

        return $form;
    }

    /**
     *
     * Create a new expertiseLevel object
     * @return      object
     *
     */
    public function newExpertiseLevel() {
        $expertiseLevel = new ExpertiseLevel();
        return $expertiseLevel;
    }

    /**
     *
     * Save a expertiseLevel to database
     * @param       expertiseLevel $expertiseLevel object
     * @return      void
     *
     */
    public function saveExpertiseLevel($expertiseLevel) {
        $this->entityManager->persist($expertiseLevel);
        $this->entityManager->flush();
    }
    
    /**
     *
     * Delete a expertiseLevel from database
     * @param       expertiseLevel $expertiseLevel object
     * @return      void
     *
     */
    public function deleteExpertiseLevel($expertiseLevel) {
        $this->entityManager->remove($expertiseLevel);
        $this->entityManager->flush();
    }

}
