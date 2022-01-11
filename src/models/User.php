<?php

class User
{
    private $username;
    private $email;
    private $accountType;



    public function __construct(
        string $username,
        string $email,
        string $accountType)
    {
        $this->username = $username;
        $this->email = $email;
        $this->accountType = $accountType;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }










    
}