<?php

namespace Application\Model;

use Zend\Form\Annotation;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\User;

class UnityOfWork {

    /** @ORM\Column(name="date_created", type="datetime", nullable=false) 
     * @Annotation\Exclude()
     */
    protected $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /** @ORM\Column(name="date_changed", type="datetime", nullable=true) */
    protected $dateChanged;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="changed_by", referencedColumnName="id")
     */
    protected $changedBy;

    /** @ORM\Column(name="date_deleted", type="datetime", nullable=true) */
    protected $dateDeleted;

    /**
     * @ORM\ManyToOne(targetEntity="User\Entity\User")
     * @ORM\JoinColumn(name="deleted_by", referencedColumnName="id")
     */
    protected $deletedBy;

    /** @ORM\Column(name="deleted", type="integer", length=1, nullable=true) */
    protected $deleted = 0;

    function getDateCreated() {
        return $this->dateCreated;
    }

    function getDateChanged() {
        return $this->dateChanged;
    }

    function getDateDeleted() {
        return $this->dateDeleted;
    }

    function getDeleted() {
        return $this->deleted;
    }

    function setDateCreated($dateCreated) {
        $this->dateCreated = $dateCreated;
    }

    function setDateChanged($dateChanged) {
        $this->dateChanged = $dateChanged;
    }

    function setDateDeleted($dateDeleted) {
        $this->dateDeleted = $dateDeleted;
    }

    function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    function getCreatedBy() {
        return $this->createdBy;
    }

    function getChangedBy() {
        return $this->changedBy;
    }

    function setCreatedBy($createdBy) {
        $this->createdBy = $createdBy;
    }

    function setChangedBy($changedBy) {
        $this->changedBy = $changedBy;
    }

    function getDeletedBy() {
        return $this->deletedBy;
    }

    function setDeletedBy($deletedBy) {
        $this->deletedBy = $deletedBy;
    }

}
