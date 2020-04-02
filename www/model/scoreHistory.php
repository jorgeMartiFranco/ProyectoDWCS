<?php 

use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves score history information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="HISTORICO_PUNTUACIONES")
 */
class ScoreHistory  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_PUNTUACION") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="datetime", name="FECHA")
     */
    private $date;
    
    /**
     * @ORM\OneToOne(targetEntity="ScoreType")
     * @ORM\JoinColumn(name="TIPO_PUNTUACION",referencedColumnName="ID_TIPO_PUNTUACION")
     */
    private $score_type;
    /**
     * @ORM\OneToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO",referencedColumnName="ID_SOCIO")
     */
    private $partner;
    
    /**
     * Creates the ScoreHistory and sets params to it.
     * @param datetime $date Score date.
     * @param MobilitySharp\model\ScoreType $score_type Score type.
     * @param MobilitySharp\model\Partner $partner Partner who has done an action.
     */
    function __construct($date, $score_type, $partner) {
        $this->date = $date;
        $this->score_type = $score_type;
        $this->partner = $partner;
    }

    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getScore_type() {
        return $this->score_type;
    }

    function getPartner() {
        return $this->partner;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setScore_type($score_type) {
        $this->score_type = $score_type;
    }

    function setPartner($partner) {
        $this->partner = $partner;
    }


    
}
?>