<?php

namespace Projects\Entities;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Model\UnityOfWork;

/**
 * This class represents a project item.
 * @ORM\Entity()
 * @ORM\Table(name="projects")
 */
class Project extends UnityOfWork {

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Many Projects have Many Project types.
     * @ORM\ManyToMany(targetEntity="ProjectType", inversedBy="projects")
     * @ORM\JoinTable(name="users_groups")
     */
    private $projectTypes;

    public function __construct() {
        $this->projectTypes = new ArrayCollection();
    }

    function getId() {
        return $this->id;
    }

    function getProjectTypes() {
        return $this->projectTypes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setProjectTypes($projectTypes) {
        $this->projectTypes = $projectTypes;
    }

}
