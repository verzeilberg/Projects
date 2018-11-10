<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a project phase item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="project_phases")
 */
class ProjectPhase {

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
     * @ORM\Column(name="version", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Version",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Version"})
     */
    protected $version;

    /**
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * Many ProjectPhase have One ProjectPhaseType.
     * @ORM\ManyToOne(targetEntity="ProjectPhaseType", inversedBy="projectPhases")
     * @ORM\JoinColumn(name="project_phase_type_id", referencedColumnName="id")
     */
    private $projectPhaseType;

    /**
     * Many ProjectPhases have Many Projects.
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="projectPhases")
     */
    private $projects;

    public function __construct() {
        $this->projects = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getVersion() {
        return $this->version;
    }

    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function getProjectPhaseType() {
        return $this->projectPhaseType;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setVersion($version) {
        $this->version = $version;
    }

    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function setProjectPhaseType($projectPhaseType) {
        $this->projectPhaseType = $projectPhaseType;
    }

    function getProjects() {
        return $this->projects;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }

}
