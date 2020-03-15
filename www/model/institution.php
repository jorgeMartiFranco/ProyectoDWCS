<?php
namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="INSTITUCIONES")
 */
class Institution {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_INSTITUCION") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="VAT")
     */
    private $vat;
    /**
     * @ORM\Column(type="string", name="NOMBRE")
     */
    private $name;
    /**
     * @ORM\Column(type="string", name="EMAIL")
     */
    private $email;
    /**
     * @ORM\Column(type="string", name="TELEFONO")
     */
    private $telephone;
    /**
     * @ORM\Column(type="string", name="CODIGO_POSTAL")
     */
    private $postal_code;
    /**
     * @ORM\Column(type="string", name="DIRECCION")
     */
    private $location;
    /**
     * @ORM\Column(type="string", name="WEB")
     */
    private $web;
    /**
     * @ORM\Column(type="string", name="DESCRIPCION")
     */
    private $description;
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
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="PAIS",referencedColumnName="ID_PAIS")
     */
    private $country;
    /**
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO",referencedColumnName="ID_SOCIO")
     */
    private $partner;
    /**
     * @ORM\ManyToOne(targetEntity="InstitutionType")
     * @ORM\JoinColumn(name="TIPO",referencedColumnName="ID_TIPO_INSTITUCION")
     */
    private $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="SpecialtyType", inversedBy="institutions")
     * @ORM\JoinTable(name="instituciones_especialidades", @ORM\JoinColumn(name="INSTITUCION", referencedColumnName="ID_INSTITUCION"),
     * @ORM\JoinColumn(name="ESPECIALIDAD", referencedColumnName="ID_ESPECIALIDAD"))
     */
    private $specialties;
    
    
    function __construct($name, $email, $telephone, $postal_code, $location, $country, $partner, $type,$registration_date) {
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->postal_code = $postal_code;
        $this->location = $location;
        $this->country = $country;
        $this->partner = $partner;
        $this->type = $type;
        $this->specialties = new \Doctrine\Common\Collections\ArrayCollection();
        $this->registration_date=$registration_date;
        
    }
    
    function getId() {
        return $this->id;
    }

    function getVat() {
        return $this->vat;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function getPostal_code() {
        return $this->postal_code;
    }

    function getLocation() {
        return $this->location;
    }

    function getWeb() {
        return $this->web;
    }

    function getDescription() {
        return $this->description;
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

    function getCountry() {
        return $this->country;
    }

    function getPartner() {
        return $this->partner;
    }

    function getType() {
        return $this->type;
    }

    function getSpecialties() {
        return $this->specialties;
    }

    function setVat($vat) {
        $this->vat = $vat;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    function setPostal_code($postal_code) {
        $this->postal_code = $postal_code;
    }

    function setLocation($location) {
        $this->location = $location;
    }

    function setWeb($web) {
        $this->web = $web;
    }

    function setDescription($description) {
        $this->description = $description;
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

    function setCountry($country) {
        $this->country = $country;
    }

    function setPartner($partner) {
        $this->partner = $partner;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSpecialties($specialties) {
        $this->specialties = $specialties;
    }



}

