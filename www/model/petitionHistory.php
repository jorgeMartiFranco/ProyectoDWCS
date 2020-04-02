<?php

use Doctrine\ORM\Mapping as ORM;
/**
 * Creates an object who saves petition
 */
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
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="ESTADO",referencedColumnName="ID_ESTADO")
     */
    private $status;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO_EMISOR",referencedColumnName="ID_SOCIO")
     */
    private $sender_partner;
    
    /**
     * @ORM\ManyToOne(targetEntity="Partner")
     * @ORM\JoinColumn(name="SOCIO_RECEPTOR",referencedColumnName="ID_SOCIO")
     */
    private $receiver_partner;
    /**
     * Creates the PetitionHistory and sets params to it.
     * @param string $subject Petition subject.
     * @param datetime $date Petition date.
     * @param MobilitySharp\model\Status $status Petition status.
     * @param MobilitySharp\model\Partner $sender_partner Partner which sends the petition.
     * @param MobilitySharp\model\Partner $receiver_partner Partner which receives the petition.
     */
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




?>