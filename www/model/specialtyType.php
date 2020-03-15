<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="TIPOS_ESPECIALIDAD")
 */
class SpecialtyType    {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_ESPECIALIDAD") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="TIPO")
     */
    private $type;
    /**
     * @ORM\Column(type="string", name="DESCRIPCION")
     */
    private $description;
    
    /**
    * @ManyToMany(targetEntity="Institution", mappedBy="specialties")
    */
    private $institutions;
    /**
    * @ManyToMany(targetEntity="Enterprise", mappedBy="specialties")
    */
    private $enterprises;
    /**
    * @ManyToMany(targetEntity="Student", mappedBy="specialties")
    */
    private $students;
    
    function __construct($type) {
        $this->type = $type;
        $this->institutions = new \Doctrine\Common\Collections\ArrayCollection;
        $this->enterprises = new \Doctrine\Common\Collections\ArrayCollection;
        $this->students = new \Doctrine\Common\Collections\ArrayCollection;
    }

    function getId() {
        return $this->id;
    }

    function getType() {
        return $this->type;
    }

    function getDescription() {
        return $this->description;
    }

    function getInstitutions() {
        return $this->institutions;
    }

    function getEnterprises() {
        return $this->enterprises;
    }

    function getStudents() {
        return $this->students;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setInstitutions($institutions) {
        $this->institutions = $institutions;
    }

    function setEnterprises($enterprises) {
        $this->enterprises = $enterprises;
    }

    function setStudents($students) {
        $this->students = $students;
    }


}

?>

