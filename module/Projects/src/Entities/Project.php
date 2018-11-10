<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a project item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="projects")
 */
class Project {

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
     * "label": "Last name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected $name;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="ProjectType", inversedBy="projects")
     * @ORM\JoinColumn(name="project_type_id", referencedColumnName="id")
     */
    private $projectType;

    /**
     * Many Projects have One customer.
     * @ORM\ManyToOne(targetEntity="Customers\Entities\Customer", inversedBy="projects")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    private $customer;

    /**
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * Many Projects have Many Project phases.
     * @ORM\ManyToMany(targetEntity="ProjectPhase", inversedBy="projects")
     * @ORM\JoinTable(name="projects_phases")
     */
    private $projectPhases;

    /**
     * Many Projects have Many Risk factors.
     * @ORM\ManyToMany(targetEntity="RiskFactor", mappedBy="projects")
     */
    private $riskFactors;

    /**
     * Many Projects have Many Expertises.
     * @ORM\ManyToMany(targetEntity="Expertise", mappedBy="projects")
     */
    private $expertises;

    public function __construct() {
        $this->projectPhases = new ArrayCollection();
        $this->riskFactors = new ArrayCollection();
        $this->expertises = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getProjectTypes() {
        return $this->projectTypes;
    }

    function getCustomer() {
        return $this->customer;
    }

    function getStartDate() {
        return $this->startDate;
    }

    function getEndDate() {
        return $this->endDate;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setProjectTypes($projectTypes) {
        $this->projectTypes = $projectTypes;
    }

    function setCustomer($customer) {
        $this->customer = $customer;
    }

    function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    function getProjectType() {
        return $this->projectType;
    }

    function setProjectType($projectType) {
        $this->projectType = $projectType;
    }

    function getProjectPhases() {
        return $this->projectPhases;
    }

    function setProjectPhases($projectPhases) {
        $this->projectPhases = $projectPhases;
    }

    function getRiskFactors() {
        return $this->riskFactors;
    }

    function setRiskFactors($riskFactors) {
        $this->riskFactors = $riskFactors;
    }

    function getExpertises() {
        return $this->expertises;
    }

    function setExpertises($expertises) {
        $this->expertises = $expertises;
    }


}
