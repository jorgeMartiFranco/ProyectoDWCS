<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ALUMNOS")
 */
class Student  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_ALUMNO") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="VAT")
     */
    private $vat;
    /**
     * @ORM\Column(type="string", name="NOMBRE_COMPLETO")
     */
    private $full_name;
    /**
     * @ORM\Column(type="string", name="CARGO_RESPONSABLE")
     */
    private $gender;
    /**
     * @ORM\Column(type="string", name="GENERO")
     */
    private $birth_date;
    /**
     * @ORM\Column(type="date", name="FECHA_ALTA")
     */
    private $registration_date;
    /**
     * @ORM\Column(type="date", name="FECHA_BAJA")
     */
    private $termination_date;
    /**
     * @ORM\Column(type="datetime", name="FECHA_MODIFICACION")
     */
    private $modification_date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO",referencedColumnName="ID_SOCIO")
     */
    private $partner;
    
    /**
     * @ORM\ManyToMany(targetEntity="SpecialtyType", inversedBy="students")
     * @ORM\JoinTable(name="alumnos_especialidades", @ORM\JoinColumn(name="ALUMNO", referencedColumnName="ID_ALUMNO"),
     * @ORM\JoinColumn(name="ESPECIALIDAD", referencedColumnName="ID_ESPECIALIDAD"))
     */
    private $specialties;
    
    function __construct($full_name, $gender, $birth_date, $partner) {
        $this->full_name = $full_name;
        $this->gender = $gender;
        $this->birth_date = $birth_date;
        $this->partner = $partner;
        $this->specialties = new \Doctrine\Common\Collections\ArrayCollection;
    }

    function getId() {
        return $this->id;
    }

    function getVat() {
        return $this->vat;
    }

    function getFull_name() {
        return $this->full_name;
    }

    function getGender() {
        return $this->gender;
    }

    function getBirth_date() {
        return $this->birth_date;
    }

    function getRegistration_date() {
        return $this->registration_date;
    }

    function getTermination_date() {
        return $this->termination_date;
    }

    function getModification_date() {
        return $this->modification_date;
    }

    function getPartner() {
        return $this->partner;
    }

    function getSpecialties() {
        return $this->specialties;
    }

    function setVat($vat) {
        $this->vat = $vat;
    }

    function setFull_name($full_name) {
        $this->full_name = $full_name;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setBirth_date($birth_date) {
        $this->birth_date = $birth_date;
    }

    function setRegistration_date($registration_date) {
        $this->registration_date = $registration_date;
    }

    function setTermination_date($termination_date) {
        $this->termination_date = $termination_date;
    }

    function setModification_date($modification_date) {
        $this->modification_date = $modification_date;
    }

    function setPartner($partner) {
        $this->partner = $partner;
    }

    function setSpecialties($specialties) {
        $this->specialties = $specialties;
    }


}

?>

