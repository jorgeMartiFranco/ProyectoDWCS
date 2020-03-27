<?php
namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Creates an object who saves partner information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="SOCIOS")
 */
class Partner {
     /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_SOCIO") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="VAT")
     */
    private $vat;
    /**
     * @ORM\Column(type="string", name="PASSWORD")
     */
    private $password;
    /**
     * @ORM\Column(type="string", name="USUARIO")
     */
    private $username;
    /**
     * @ORM\Column(type="string", name="NOMBRE_COMPLETO")
     */
    private $full_name;
    /**
     * @ORM\Column(type="string", name="EMAIL")
     */
    private $email;
    /**
     * @ORM\Column(type="string", name="TELEFONO")
     */
    private $telephone;
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
     * @ORM\Column(type="string", name="CARGO")
     */
    private $post;
    /**
     * @ORM\Column(type="string", name="DEPARTAMENTO")
     */
    private $department;
    /**
     * @ORM\Column(type="boolean", name="R_ALOJAMIENTO")
     */
    private $lodging_provider;
    /**
     * @ORM\Column(type="integer", name="PUNTUACION")
     */
    private $score;
    /**
     * @ORM\ManyToOne(targetEntity="Role")
     * @ORM\JoinColumn(name="ROL",referencedColumnName="ID_ROL")
     */
    private $role;
    /**
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="INSTITUCION",referencedColumnName="ID_INSTITUCION")
     */
    private $institution;
    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumn(name="PAIS",referencedColumnName="ID_PAIS")
     */
    private $country;
    /**
     * Creates the Partner and sets params to it.
     * @param string $password Partner password.
     * @param string $username Partner username.
     * @param string $full_name Partner full name.
     * @param string $email Partner email.
     * @param string $telephone Partner phone.
     * @param string $post Partner post.
     * @param string $department Partner department.
     * @param MobilitySharp\model\Role $role Partner role.
     * @param MobilitySharp\model\Country $country Partner country.
     * @param date $registration_date Partner registration date.
     */
    function __construct($password, $username, $full_name, $email, $telephone, $post, $department, $role, $country,$registration_date) {
        $this->password = $password;
        $this->username = $username;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->post = $post;
        $this->department = $department;
        $this->role = $role;
        $this->country = $country;
        $this->registration_date = $registration_date;
    }
    
    function getId() {
        return $this->id;
    }

    function getVat() {
        return $this->vat;
    }

    function getPassword() {
        return $this->password;
    }

    function getUsername() {
        return $this->username;
    }

    function getFull_name() {
        return $this->full_name;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelephone() {
        return $this->telephone;
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

    function getPost() {
        return $this->post;
    }

    function getDepartment() {
        return $this->department;
    }

    function getLodging_provider() {
        return $this->lodging_provider;
    }

    function getScore() {
        return $this->score;
    }

    function getRole() {
        return $this->role;
    }

    function getInstitution() {
        return $this->institution;
    }

    function getCountry() {
        return $this->country;
    }

    function setVat($vat) {
        $this->vat = $vat;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setFull_name($full_name) {
        $this->full_name = $full_name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
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

    function setPost($post) {
        $this->post = $post;
    }

    function setDepartment($department) {
        $this->department = $department;
    }

    function setLodging_provider($lodging_provider) {
        $this->lodging_provider = $lodging_provider;
    }

    function setScore($score) {
        $this->score = $score;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setInstitution($institution) {
        $this->institution = $institution;
    }

    function setCountry($country) {
        $this->country = $country;
    }



}



?>

