<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Creates an object who saves enterprise type information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="TIPOS_EMPRESA")
 */
class EnterpriseType  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_TIPO_EMPRESA") @ORM\GeneratedValue
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
     * Creates the EnterpriseType and sets params to it.
     * @param string $type Enterprise type.
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