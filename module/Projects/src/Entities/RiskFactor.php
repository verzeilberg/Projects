<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a risk factor item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="risk_factors")
 */
class RiskFactor {
    
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
     * @ORM\Column(name="level", type="integer", length=11, nullable=false)
     * @Annotation\Options({
     * "label": "Level",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected $level;

    /**
     * Many Risk factors have Many Projects.
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="riskFactors")
     * @ORM\JoinTable(name="riskfactors_projects")
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

    function getLevel() {
        return $this->level;
    }

    function getProjects() {
        return $this->projects;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }



}
