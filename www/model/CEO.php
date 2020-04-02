<?php

use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves CEO information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="RESPONSABLES")
 */
class CEO   {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_RESPONSABLE") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="EMAIL")
     */
    private $email;
    /**
     * @ORM\Column(type="string", name="NOMBRE_COMPLETO")
     */
    private $full_name;
    /**
     * @ORM\Column(type="string", name="TELEFONO")
     */
    private $telephone;
            
    /**
     * Creates the CEO and sets params to it.
     * @param string $email CEO's email.
     * @param string $full_name CEO's full name.
     */
    function __construct($email, $full_name) {
        $this->email = $email;
        $this->full_name = $full_name;
    }

    function getId() {
        return $this->id;
    }

    function getEmail() {
        return $this->email;
    }

    function getFull_name() {
        return $this->full_name;
    }

    function getTelephone() {
        return $this->telephone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFull_name($full_name) {
        $this->full_name = $full_name;
    }

    function setTelephone($telephone) {
        $this->telephone = $telephone;
    }


}
?>
