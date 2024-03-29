<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Creates an object who saves institution type information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="TIPOS_INSTITUCION")
 */
class InstitutionType {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_TIPO_INSTITUCION") @ORM\GeneratedValue
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
     * Creates the Country and sets params to it.
     * @param string $type Institution type.
     */
    function __construct($type) {
        $this->type = $type;
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

    function setType($type) {
        $this->type = $type;
    }

    function setDescription($description) {
        $this->description = $description;
    }



    
}
?>
