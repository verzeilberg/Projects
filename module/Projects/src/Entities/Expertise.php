<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a expertise item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="expertises")
 */
class Expertise {

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
     * Many Expertise have Many Projects.
     * @ORM\ManyToMany(targetEntity="Project", inversedBy="expertises")
     * @ORM\JoinTable(name="expertises_projects")
     */
    private $projects;
    
        /**
     * Many Expertises have Many Expertise levels
     * @ORM\ManyToMany(targetEntity="ExpertiseLevel", inversedBy="expertises")
     * @ORM\JoinTable(name="expertiselevels_expertises")
     */
    private $expertiseLevels;

    public function __construct() {
        $this->projects = new ArrayCollection();
        $this->expertiseLevels = new ArrayCollection();
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

    function getExpertiseLevels() {
        return $this->expertiseLevels;
    }

    function setExpertiseLevels($expertiseLevels) {
        $this->expertiseLevels = $expertiseLevels;
    }



}
