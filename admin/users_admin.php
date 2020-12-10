<?php

class UsersAdmin
{
    private $dbo = null;
    
    function __construct() {
        $this->dbo=$dbo;
    }
    function getQuerySingleResult($query)
    {
       if(!$this->dbo) return false;
        
        if(!$result= $this->dbo->query($query))
        {
            return false;
        }
        
        if ($row = $result->fetch_row()) {
            return $row[0];
        } else {
            return false;
        } 
    }
    
}