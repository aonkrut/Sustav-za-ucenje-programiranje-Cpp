<?php

class Home extends Model{

    function getUsers(){
       $users = $this->selectFrom("SELECT ime, prezime, email FROM korisnik;", array())['data'];
       return $users;
    }



}


?>