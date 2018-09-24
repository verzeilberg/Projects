<?php

namespace Customers\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a country item.
 * @ORM\Entity()
 * @ORM\Table(name="countries")
 */
class Country extends UnityOfWork {

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
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 form-control-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Name"})
     */
    protected $name;

    /**
     * @ORM\Column(name="short_name", type="string", length=255, nullable=false)
     * @Annotation\Options({
     * "label": "Short name",
     * "label_attributes": {"class": "col-sm-4 col-md-4 col-lg-4 form-control-label"}
     * })
     * @Annotation\Attributes({"class":"form-control", "placeholder":"Short name"})
     */
    protected $shortName;

    /**
     * One Country has One flag file.
     * @ORM\OneToOne(targetEntity="UploadFiles\Entity\UploadFiles")
     * @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     */
    private $flag;

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getShortName() {
        return $this->shortName;
    }

    function getFlag() {
        return $this->flag;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setShortName($shortName) {
        $this->shortName = $shortName;
    }

    function setFlag($flag) {
        $this->flag = $flag;
    }

}
