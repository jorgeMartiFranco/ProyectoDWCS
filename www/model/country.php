<?php

namespace MobilitySharp\model;

use Doctrine\ORM\Mapping as ORM;

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
