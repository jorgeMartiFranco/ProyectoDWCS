<?php
namespace MobilitySharp\model;

class Institution {
    private $id;
    private $vat;
    private $name;
    private $email;
    private $telephone;
    private $postal_code;
    private $location;
    private $web;
    private $description;
    private $registration_date;
    private $termination_date;
    private $modification_date;
    private $country;
    private $partner;
    private $type;
    private $specialties;
}

class InstitutionType {
    private $id;
    private $type;
    private $description;
}