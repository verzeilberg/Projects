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
     * @ORM\ManyToOne(targetEntity="Level")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="Expertise")
     * @ORM\JoinColumn(name="expertise_id", referencedColumnName="id")
     */
    private $expertise;

    /**
     * Many ExpertiseLevels have one consultant. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Consultant", inversedBy="expertiseLevels")
     * @ORM\JoinColumn(name="consultant_id", referencedColumnName="id")
     */
    private $consultant;

    function getId() {
        return $this->id;
    }

    function getLevel() {
        return $this->level;
    }

    function getExpertise() {
        return $this->expertise;
    }

    function getConsultant() {
        return $this->consultant;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function setExpertise($expertise) {
        $this->expertise = $expertise;
    }

    function setConsultant($consultant) {
        $this->consultant = $consultant;
    }

}
