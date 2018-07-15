<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a permission.
 * @ORM\Entity()
 * @ORM\Table(name="permission")
 */
class Permission
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** 
     * @ORM\Column(name="name", type="string", length=255, nullable=false)  
     */
    protected $name;
    
    /** 
     * @ORM\Column(name="description", type="text", nullable=true)  
     */
    protected $description;

    /** 
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $dateCreated;
    
    /**
     * @ORM\ManyToMany(targetEntity="User\Entity\Role", mappedBy="permissions")
     * @ORM\JoinTable(name="role_permission",
     *      joinColumns={@ORM\JoinColumn(name="permission_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles;

    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->roles = new ArrayCollection();
    }
    
    public function getId() 
    {
        return $this->id;
    }

    public function setId($id) 
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = new \DateTime($dateCreated);
    }
    
    public function getRoles()
    {
        return $this->roles;
    }
}



