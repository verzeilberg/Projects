<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\ProjectType;

class projectTypeService implements projectTypeServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of projectTypes
     *
     * @return      array
     *
     */
    public function getProjectTypes() {

        $projectTypes = $this->entityManager->getRepository(ProjectType::class)
                ->findBy([], ['dateCreated' => 'DESC']);

        return $projectTypes;
    }

    /**
     *
     * Get project type object by on id
     *
     * @param       id  $id The id to fetch the project type from the database
     * @return      object
     *
     */
    public function getProject($id) {
        $projectType = $this->entityManager->getRepository(ProjectType::class)
                ->findOneBy(['id' => $id], []);

        return $projectType;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $projectType
     * @return      form
     *
     */
    public function createForm($projectType) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($projectType);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Projects\Entity\ProjectType'));
        $form->bind($projectType);

        return $form;
    }

    /**
     *
     * Create a new project type object
     * @return      object
     *
     */
    public function newProjectType() {
        $projectType = new ProjectType();
        return $projectType;
    }

    /**
     *
     * Save a project type to database
     * @param       project type $projectType object
     * @return      void
     *
     */
    public function saveProjectType($projectType) {
        $this->entityManager->persist($projectType);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a project type from database
     * @param       project type $projectType object
     * @return      void
     *
     */
    public function deleteProjectType($projectType) {
        $this->entityManager->remove($projectType);
        $this->entityManager->flush();
    }

}
