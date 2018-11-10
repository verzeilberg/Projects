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
 * @ORM\Table(name="expertise_levels")
 */
class ExpertiseLevel {

    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many Expertise levels have Many Levels.
     * @ORM\ManyToMany(targetEntity="Level", mappedBy="expertiseLevels")
     */
    private $levels;
    
        /**
     * Many Expertise levels have Many Expertises.
     * @ORM\ManyToMany(targetEntity="Expertise", mappedBy="expertiseLevels")
     */
    private $expertises;
    
        /**
     * Many Expertise levels have Many Consultants.
     * @ORM\ManyToMany(targetEntity="Consultant", mappedBy="expertiseLevels")
     */
    private $consultants;


    public function __construct() {
        $this->levels = new ArrayCollection();
        $this->expertises = new ArrayCollection();
        $this->consultants = new ArrayCollection();
    }
    
    function getId() {
        return $this->id;
    }

    function getLevels() {
        return $this->levels;
    }

    function getExpertises() {
        return $this->expertises;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLevels($levels) {
        $this->levels = $levels;
    }

    function setExpertises($expertises) {
        $this->expertises = $expertises;
    }

    function getConsultants() {
        return $this->consultants;
    }

    function setConsultants($consultants) {
        $this->consultants = $consultants;
    }



}
