<?php

namespace Customers\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a customer item.
 * @ORM\Entity()
 * @ORM\Table(name="customers")
 */
class Customer extends UnityOfWork {

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
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * @Annotation\Type("DoctrineModule\Form\Element\ObjectSelect")
     * @Annotation\Options({
     * "empty_option": "---",
     * "target_class":"Customers\Entities\Country",
     * "property": "shortName",
     * "label": "Country",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control"})
     */
    private $country;

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

    function getCountry() {
        return $this->country;
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

    function setCountry($country) {
        $this->country = $country;
    }

}
