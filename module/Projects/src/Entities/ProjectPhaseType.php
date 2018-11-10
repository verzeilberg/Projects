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
 * @ORM\Table(name="project_phase_types")
 */
class ProjectPhaseType {

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
     * One ProjectPhaseType has Many Project phases.
     * @ORM\OneToMany(targetEntity="ProjectPhase", mappedBy="projectPhaseType")
     */
    private $projectPhases;
    
        /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="ProjectType", inversedBy="projectPhaseTypes")
     * @ORM\JoinColumn(name="project_type_id", referencedColumnName="id")
     */
    private $projectType;

     public function __construct() {
        $this->projectPhases = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getProjectPhaseTypes() {
        return $this->projectPhaseTypes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setProjectPhaseTypes($projectPhaseTypes) {
        $this->projectPhaseTypes = $projectPhaseTypes;
    }
    
    function getProjectPhases() {
        return $this->projectPhases;
    }

    function getProjectType() {
        return $this->projectType;
    }

    function setProjectPhases($projectPhases) {
        $this->projectPhases = $projectPhases;
    }

    function setProjectType($projectType) {
        $this->projectType = $projectType;
    }



}
