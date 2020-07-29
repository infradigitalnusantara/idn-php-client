<?php
namespace InfraDigital\ApiClient\Entity;

class MainEntity
{
    private $username;
    private $password;
    private $devMode = false;

    /**
     * @return bool
     */
    public function isDevMode()
    {
        return $this->devMode;
    }

    /**
     * @param bool $devMode
     */
    public function setDevMode()
    {
        $this->devMode = true;
    }

    /**
     * @param bool $devMode
     */
    public function unsetDevMode()
    {
        $this->devMode = false;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
}