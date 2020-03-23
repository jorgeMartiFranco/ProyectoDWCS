<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="ESTADOS")
 */
class Status  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_ESTADO") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="string", name="ESTADO")
     */
    private $status;
    /**
     * @ORM\Column(type="string", name="DESCRIPCION")
     */
    private $description;
    
    
    function __construct($status) {
        $this->status = $status;
    }

    
    function getId() {
        return $this->id;
    }

    function getStatus() {
        return $this->status;
    }

    function getDescription() {
        return $this->description;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setDescription($description) {
        $this->description = $description;
    }


}
?>

