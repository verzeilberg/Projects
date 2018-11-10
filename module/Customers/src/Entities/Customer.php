<?php

namespace Customers\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Application\Traits\SoftDeleteableEntity;
use Application\Traits\TimestampableEntity;

/**
 * This class represents a customer item.
 * @ORM\Entity()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false, hardDelete=false)
 * @ORM\Table(name="customers")
 */
class Customer {

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
     * "label_attributes": {"class": "col-lg-4 col-md-4 col-sm-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected $name;

    /**
     * @ORM\Column(name="visit_street", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Visit street & number",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"visit street"})
     */
    protected $visitStreet;

    /**
     * @ORM\Column(name="visit_number", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Visit number",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"visit number"})
     */
    protected $visitNumber;

    /**
     * @ORM\Column(name="visit_city", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Visit city",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"visit city"})
     */
    protected $visitCity;

    /**
     * @ORM\Column(name="visit_postal_code", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Visit postal code & city",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"visit postal code"})
     */
    protected $visitPostalCode;

    /**
     * @ORM\ManyToOne(targetEntity="Translator\Entities\Language")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id", onDelete="SET NULL")
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "empty_option": "---",
     * "target_class":"Translator\Entities\Language",
     * "property": "shortName",
     * "label": "Language",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control"})
     */
    private $language;

    /**
     * One Customer has Many Contacts.
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="customer")
     */
    private $contacts;

    /**
     * One Customer has Many Projects.
     * @ORM\OneToMany(targetEntity="Projects\Entities\Project", mappedBy="customer")
     */
    private $projects;

    public function __construct() {
        $this->contacts = new ArrayCollection();
        $this->projects = new ArrayCollection();
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

    function getVisitStreet() {
        return $this->visitStreet;
    }

    function getVisitNumber() {
        return $this->visitNumber;
    }

    function getVisitCity() {
        return $this->visitCity;
    }

    function getVisitPostalCode() {
        return $this->visitPostalCode;
    }

    function getLanguage() {
        return $this->language;
    }

    function setVisitStreet($visitStreet) {
        $this->visitStreet = $visitStreet;
    }

    function setVisitNumber($visitNumber) {
        $this->visitNumber = $visitNumber;
    }

    function setVisitCity($visitCity) {
        $this->visitCity = $visitCity;
    }

    function setVisitPostalCode($visitPostalCode) {
        $this->visitPostalCode = $visitPostalCode;
    }

    function setLanguage($language) {
        $this->language = $language;
    }

    function getContacts() {
        return $this->contacts;
    }

    function setContacts($contacts) {
        $this->contacts = $contacts;
    }

    function getProjects() {
        return $this->projects;
    }

    function setProjects($projects) {
        $this->projects = $projects;
    }

}
