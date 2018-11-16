<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\Level;

class levelService implements levelServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of levels
     *
     * @return      array
     *
     */
    public function getLevels() {

        $levels = $this->entityManager->getRepository(Level::class)
                ->findBy(
                    ['deletedAt' => null],
                    ['sortOrder' => 'ASC']
                );

        return $levels;
    }

    /**
     *
     * Get level object by on id
     *
     * @param       id  $id The id to fetch the level from the database
     * @return      object
     *
     */
    public function getLevel($id) {
        $level = $this->entityManager->getRepository(Level::class)
                ->findOneBy(['id' => $id], []);

        return $level;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $level
     * @return      form
     *
     */
    public function createForm($level) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($level);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Levels\Entity\Level'));
        $form->bind($level);

        return $form;
    }

    /**
     *
     * Create a new level object
     * @return      object
     *
     */
    public function newLevel() {
        $level = new Level();
        return $level;
    }

    /**
     *
     * Save a level to database
     * @param       level $level object
     * @return      void
     *
     */
    public function saveLevel($level) {
        $this->entityManager->persist($level);
        $this->entityManager->flush();
    }
    
    /**
     *
     * Delete a level from database
     * @param       level $level object
     * @return      void
     *
     */
    public function deleteLevel($level) {
        $this->entityManager->remove($level);
        $this->entityManager->flush();
    }

}
