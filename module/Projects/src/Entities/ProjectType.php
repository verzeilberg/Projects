<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a project type item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="project_types")
 */
class ProjectType {
    
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected $name;

    /**
     * One ProjectType has Many Projects.
     * @ORM\OneToMany(targetEntity="Project", mappedBy="projectType")
     */
    private $projects;

    /**
     * One ProjectType has Many Project Phase Type.
     * @ORM\OneToMany(targetEntity="ProjectPhaseType", mappedBy="projectType")
     */
    private $projectPhaseTypes;

    public function __construct() {
        $this->projects = new ArrayCollection();
        $this->projectPhaseTypes = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getProjects() {
        return $this->projects;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }
    
    function getProjectPhaseTypes() {
        return $this->projectPhaseTypes;
    }

    function setProjectPhaseTypes($projectPhaseTypes) {
        $this->projectPhaseTypes = $projectPhaseTypes;
    }



}
