<?php


use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves country information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="PAISES")
 */
class Country {

    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_PAIS") @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="CODIGO_PAIS")
     */
    private $country_code;

    /**
     * @ORM\Column(type="string", name="NOMBRE")
     */
    private $name;

    /**
     * Creates the Country and sets params to it.
     * @param string $country_code Country code.
     * @param string $name Country name.
     */
    function __construct($country_code, $name) {
        $this->country_code = $country_code;
        $this->name = $name;
    }
    
    function getId() {
        return $this->id;
    }

    function getCountry_code() {
        return $this->country_code;
    }

    function getName() {
        return $this->name;
    }

    function setCountry_code($country_code) {
        $this->country_code = $country_code;
    }

    function setName($name) {
        $this->name = $name;
    }



}
