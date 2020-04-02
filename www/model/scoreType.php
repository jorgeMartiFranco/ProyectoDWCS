<?php 

use Doctrine\ORM\Mapping as ORM;

/**
 * Creates an object who saves score type information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="TIPOS_PUNTUACION")
 */
class ScoreType  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_TIPO_PUNTUACION") @ORM\GeneratedValue
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
     * @ORM\Column(type="integer", name="VALOR")
     */
    private $value;
    
    /**
     * Creates the ScoreType and sets params to it.
     * @param string $type Score type.
     * @param integer $value Score value.
     */
    function __construct($type, $value) {
        $this->type = $type;
        $this->value = $value;
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

    function getValue() {
        return $this->value;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setValue($value) {
        $this->value = $value;
    }



}
    ?>