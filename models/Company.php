<?php

class Company {

    public $id;
    public $name;
    public $website;
    public $address;
    public $phone;
    public $email;
    public $linkedin;

    /**
     * Getters
     */
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getLinkedIn() {
        return $this->linkedin;
    }

    /**
     * Setters
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setLinkedIn($linkedin) {
        $this->linkedin = $linkedin;
    }

    
}