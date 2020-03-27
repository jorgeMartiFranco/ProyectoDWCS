<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves institutiobn mobility information
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="MOVILIDADES_INSTITUCIONES")
 */
class InstitutionMobility  {
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
     * @ORM\OneToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="INSTITUCION",referencedColumnName="ID_INSTITUCION")
     */
    private $institution;
    
    /**
     * Creates the InstitutionMobility and sets params to it.
     * @param date $start_date Mobility start date.
     * @param date $estimated_end_date Mobility end date.
     * @param date $registration_date Mobility registration date.
     * @param MobilitySharp\model\Student $student Mobility student.
     * @param MobilitySharp\model\Institution $institution Mobility institution.
     */
    function __construct($start_date, $estimated_end_date, $registration_date, $student, $institution) {
        $this->start_date = $start_date;
        $this->estimated_end_date = $estimated_end_date;
        $this->registration_date = $registration_date;
        $this->student = $student;
        $this->institution = $institution;
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

    function getInstitution() {
        return $this->institution;
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

    function setInstitution($institution) {
        $this->institution = $institution;
    }



}

?>