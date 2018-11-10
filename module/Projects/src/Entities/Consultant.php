<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a consultant item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="consultants")
 */
class Consultant {

    use SoftDeleteableEntity;

use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="sur_name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "surName",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Surname"})
     */
    protected $surName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Last name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Last name"})
     */
    protected $lastName;

    /**
     * @ORM\Column(name="last_name_prefix", type="string", length=255, nullable=true)
     * @Annotation\Options({
     * "label": "Last name prefix",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Last name prefix"})
     */
    protected $lastNamePrefix;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "E-mail",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"E-mail"})
     */
    protected $email;

    /**
     * Many Consultants have Many Expertise levels.
     * @ORM\ManyToMany(targetEntity="ExpertiseLevel", inversedBy="consultants")
     * @ORM\JoinTable(name="consultants_expertiselevels")
     */
    private $expertiseLevels;

    public function __construct() {
        $this->expertiseLevels = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getSurName() {
        return $this->surName;
    }

    function getLastName() {
        return $this->lastName;
    }

    function getLastNamePrefix() {
        return $this->lastNamePrefix;
    }

    function getEmail() {
        return $this->email;
    }

    function getExpertiseLevels() {
        return $this->expertiseLevels;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSurName($surName) {
        $this->surName = $surName;
    }

    function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    function setLastNamePrefix($lastNamePrefix) {
        $this->lastNamePrefix = $lastNamePrefix;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setExpertiseLevels($expertiseLevels) {
        $this->expertiseLevels = $expertiseLevels;
    }

}
