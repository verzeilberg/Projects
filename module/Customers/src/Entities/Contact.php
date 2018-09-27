<?php

namespace Customers\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a contact item.
 * @ORM\Entity()
 * @ORM\Table(name="contacts")
 */
class Contact extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(name="sur_name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Sur name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Sur name"})
     */
    public $surName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Last name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Last name"})
     */
    public $lastName;

    /**
     * @ORM\Column(name="last_name_prefix", type="string", length=50, nullable=true)
     * @Annotation\Options({
     * "label": "Last name prefix",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Last name prefix"})
     */
    public $lastNamePrefix;

    /**
     * @ORM\Column(name="gender", type="integer", length=1, nullable=false)
     * @Annotation\Type("Zend\Form\Element\Radio")
     * @Annotation\Options({
     * "label": "Gender",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"},
     * "value_options":{
     * "1":"Men",
     * "2":"Woman",
     * "3":"Unknown"
     * }
     * })
     * @Annotation\Attributes({"class":"radioItem"})
     */
    public $gender;

    /**
     * @ORM\Column(name="phone_number", type="integer", length=50, nullable=true)
     * @Annotation\Options({
     * "label": "Phone number",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Phone number"})
     */
    public $phoneNumber;

    /**
     * @ORM\Column(name="mobile_phone_number", type="integer", length=50, nullable=true)
     * @Annotation\Options({
     * "label": "Mobile phone number",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Mobile phone number"})
     */
    public $mobilePhoneNumber;

    /**
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "E-mail",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 col-form-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"E-mail"})
     */
    public $email;

    /**
     * Many Contacts have One Customer.
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="contacts")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     */
    public $customer;
    
        /**
     * One contact have One Image.
     * @ORM\OneToOne(targetEntity="UploadImages\Entity\Image")
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     */
    public $contactImage;

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

    function getGender() {
        return $this->gender;
    }

    function getPhoneNumber() {
        return $this->phoneNumber;
    }

    function getMobilePhoneNumber() {
        return $this->mobilePhoneNumber;
    }

    function getEmail() {
        return $this->email;
    }

    function getCustomer() {
        return $this->customer;
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

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = $phoneNumber;
    }

    function setMobilePhoneNumber($mobilePhoneNumber) {
        $this->mobilePhoneNumber = $mobilePhoneNumber;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCustomer($customer) {
        $this->customer = $customer;
    }

}
