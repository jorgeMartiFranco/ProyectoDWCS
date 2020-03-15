<?php
namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="MOVILIDADES_EMPRESAS")
 */
class EnterpriseMobility  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_MOVILIDAD") @ORM\GeneratedValue
     */
    private $id;
    /**
     * @ORM\Column(type="date", name="FECHA_INICIO")
     */
    private $start_date;
    /**
     * @ORM\Column(type="date", name="FECHA_FIN_ESTIMADO")
     */
    private $estimated_end_date;
    /**
     * @ORM\Column(type="date", name="FECHA_FIN")
     */
    private $end_date;
    /**
     * @ORM\Column(type="datetime", name="FECHA_ALTA")
     */
    private $registration_date;
    /**
     * @ORM\OneToOne(targetEntity="Student")
     * @ORM\JoinColumn(name="ALUMNO",referencedColumnName="ID_ALUMNO")
     */
    private $student;
    /**
     * @ORM\OneToOne(targetEntity="Enterprise")
     * @ORM\JoinColumn(name="EMPRESA",referencedColumnName="ID_EMPRESA")
     */
    private $enterprise;
    
    function __construct($start_date, $estimated_end_date, $registration_date, $student, $enterprise) {
        $this->start_date = $start_date;
        $this->estimated_end_date = $estimated_end_date;
        $this->registration_date = $registration_date;
        $this->student = $student;
        $this->enterprise = $enterprise;
    }

    
    function getId() {
        return $this->id;
    }

    function getStart_date() {
        return $this->start_date;
    }

    function getEstimated_end_date() {
        return $this->estimated_end_date;
    }

    function getEnd_date() {
        return $this->end_date;
    }

    function getRegistration_date() {
        return $this->registration_date;
    }

    function getStudent() {
        return $this->student;
    }

    function getEnterprise() {
        return $this->enterprise;
    }

    function setStart_date($start_date) {
        $this->start_date = $start_date;
    }

    function setEstimated_end_date($estimated_end_date) {
        $this->estimated_end_date = $estimated_end_date;
    }

    function setEnd_date($end_date) {
        $this->end_date = $end_date;
    }

    function setRegistration_date($registration_date) {
        $this->registration_date = $registration_date;
    }

    function setStudent($student) {
        $this->student = $student;
    }

    function setEnterprise($enterprise) {
        $this->enterprise = $enterprise;
    }


}
?>
