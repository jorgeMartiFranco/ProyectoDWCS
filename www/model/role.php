<?php


use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves role information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="ROL_USUARIOS")
 */
class Role {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_ROL") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="TIPO")
     */
    private $type;
    /**
     * @ORM\Column(type="integer", name="DESCRIPCION")
     */
    private $description;
    /**
     * Creates the Role and sets params to it.
     * @param string $type Role type.
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

