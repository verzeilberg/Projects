<?php

namespace Projects\Service;

use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;

/*
 * Entities
 */
use Projects\Entities\Project;

class projectService implements projectServiceInterface {

    /**
     * Constructor.
     */
    public function __construct($entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     *
     * Get array of projects
     *
     * @return      array
     *
     */
    public function getProjects() {

        $projects = $this->entityManager->getRepository(Project::class)
                ->findBy([], ['dateCreated' => 'DESC']);

        return $projects;
    }

    /**
     *
     * Get project object by on id
     *
     * @param       id  $id The id to fetch the project from the database
     * @return      object
     *
     */
    public function getProject($id) {
        $project = $this->entityManager->getRepository(Project::class)
                ->findOneBy(['id' => $id], []);

        return $project;
    }
    
        /**
     *
     * Create form of an object
     *
     * @param       blog $event $project
     * @return      form
     *
     */
    public function createForm($project) {
        $builder = new AnnotationBuilder($this->entityManager);
        $form = $builder->createForm($project);
        $form->setHydrator(new DoctrineHydrator($this->entityManager, 'Projects\Entity\Project'));
        $form->bind($project);

        return $form;
    }

    /**
     *
     * Create a new project object
     * @return      object
     *
     */
    public function newProject() {
        $project = new Project();
        return $project;
    }

    /**
     *
     * Save a project to database
     * @param       project $project object
     * @return      void
     *
     */
    public function saveProject($project) {
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

    /**
     *
     * Delete a project from database
     * @param       project $project object
     * @return      void
     *
     */
    public function deleteProject($project) {
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

}
