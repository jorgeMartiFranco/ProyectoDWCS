<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/../vendor/autoload.php';


function sendMail($petition){
    $mail=new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug=2;
    $mail->SMTPAuth=true;
    $mail->SMTPSecure="tls";
    $mail->Host="smtp.gmail.com";
    $mail->Port=587;
    $mail->Username=""; //falta
    $mail->Password=""; //falta
    $mail->setFrom($petition->getSender_partner()->getEmail(),$petition->getSender_partner()->getFull_name());
    $mail->Subject=$petition->getSubject();
    if($description=$petition->getDescription()){
        $mail->msgHTML($description);
    }
    $mail->addAddress($petition->getReceiver_partner()->getEmail(),$petition->getReceiver_partner()->getFull_name());
    if($mail->send()){
        return true;
    }
    else {
        echo "error ".$mail->ErrorInfo;
        
        
    }
    
    
}



?>
