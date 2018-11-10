<?php

namespace Application\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * SoftDeletable Trait, usable with PHP >= 5.4
 */
trait SoftDeleteableEntity
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * Sets deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt(\DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Returns deletedAt.
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Is deleted?
     *
     * @return bool
     */
    public function isDeleted()
    {
        return null !== $this->deletedAt;
    }
}
