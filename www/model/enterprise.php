<?php
namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="EMPRESAS")
 */
class Enterprise  {
     /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_EMPRESA") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="CARGO_RESPONSABLE")
     */
    private $ceo_post;
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
     * @ORM\ManyToOne(targetEntity="CEO")
     * @ORM\JoinColumn(name="RESPONSABLE",referencedColumnName="ID_RESPONSABLE")
     */
    private $ceo;
    /**
     * @ORM\ManyToOne(targetEntity="EnterpriseType")
     * @ORM\JoinColumn(name="TIPO",referencedColumnName="ID_TIPO_EMPRESA")
     */
    private $type;
    
    /**
     * @ORM\ManyToMany(targetEntity="SpecialtyType", inversedBy="companies")
     * @ORM\JoinTable(name="EMPRESAS_ESPECIALIDADES", joinColumns={@ORM\JoinColumn(name="EMPRESA", referencedColumnName="ID_EMPRESA")},
     * inverseJoinColumns={@ORM\JoinColumn(name="ESPECIALIDAD", referencedColumnName="ID_ESPECIALIDAD")})
     */
    private $specialties;
    
    function __construct($ceo_post, $name, $email, $telephone, $postal_code, $location, $country, $partner, $ceo, $type,$registration_date) {
        $this->ceo_post = $ceo_post;
        $this->name = $name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->postal_code = $postal_code;
        $this->location = $location;
        $this->country = $country;
        $this->partner = $partner;
        $this->ceo = $ceo;
        $this->type = $type;
        $this->registration_date = $registration_date;
        $this->specialties = new \Doctrine\Common\Collections\ArrayCollection;
    }
    
    function getId() {
        return $this->id;
    }

    function getCeo_Post() {
        return $this->ceo_post;
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

    function getCeo() {
        return $this->ceo;
    }

    function getType() {
        return $this->type;
    }
    
    function getSpecialties() {
        return $this->specialties;
    }

    
    function setCeo_Post($ceo_post) {
        $this->ceo_post = $ceo_post;
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

    function setCeo($ceo) {
        $this->responsible = $ceo;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setSpecialties($specialties) {
        $this->specialties = $specialties;
    }




}






?>

