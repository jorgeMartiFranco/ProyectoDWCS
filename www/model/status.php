<?php



use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves status information
 */
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
    
    /**
     * Creates the Status and sets params to it.
     * @param string $status Status type.
     */
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

