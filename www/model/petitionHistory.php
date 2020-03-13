<?php

namespace MobilitySharp\model;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="HISTORICO_PETICIONES")
 */
class PetitionHistory   {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_PETICION") @ORM\GeneratedValue
     */
    private $id;
     /**
     * @ORM\Column(type="string", name="ASUNTO")
     */
    private $subject;
     /**
     * @ORM\Column(type="string", name="DESCRIPCION")
     */
    private $description;
     /**
     * @ORM\Column(type="datetime", name="FECHA")
     */
    private $date;
        
    /**
     * @ORM\ManyToOne(TargetEntity="Status")
     * @ORM\JoinColumn(name="ESTADO",referencedColumnName="ID_ESTADO")
     */
    private $status;
    
    /**
     * @ORM\ManyToOne(TargetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO",referencedColumnName="ID_SOCIO")
     */
    private $sender_partner;
    
    /**
     * @ORM\ManyToOne(TargetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO",referencedColumnName="ID_SOCIO")
     */
    private $receiver_partner;
    
    function __construct($subject, $date, $status, $sender_partner, $receiver_partner) {
        $this->subject = $subject;
        $this->date = $date;
        $this->status = $status;
        $this->sender_partner = $sender_partner;
        $this->receiver_partner = $receiver_partner;
    }
    
    function getId() {
        return $this->id;
    }

    function getSubject() {
        return $this->subject;
    }

    function getDescription() {
        return $this->description;
    }

    function getDate() {
        return $this->date;
    }

    function getStatus() {
        return $this->status;
    }

    function getSender_partner() {
        return $this->sender_partner;
    }

    function getReceiver_partner() {
        return $this->receiver_partner;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setSender_partner($sender_partner) {
        $this->sender_partner = $sender_partner;
    }

    function setReceiver_partner($receiver_partner) {
        $this->receiver_partner = $receiver_partner;
    }



    
}


/**
 * @ORM\Entity
 * @ORM\Table(name="ESTADOS")
 */
class Status  {
    /**
     * @ORM\Id @ORM\Column(type="integer", name="ID_PETICION") @ORM\GeneratedValue
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