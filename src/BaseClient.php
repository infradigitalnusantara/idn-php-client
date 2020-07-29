<?php
namespace InfraDigital\ApiClient;

use InfraDigital\ApiClient\Entity\MainEntity;
use InfraDigital\ApiClient\Utils\ClientUtil;

class BaseClient implements ClientInterface
{
    protected $utils;
    protected $mainEntity;

    protected function __construct($username, $plainPassword)
    {
        $this->utils        = new ClientUtil();
        $this->mainEntity   = new MainEntity();
        $this->mainEntity->setUsername($username);
        $this->mainEntity->setPassword($this->utils->passwordHash($plainPassword));
    }

    public function setDevMode()
    {
        $this->mainEntity->setDevMode();

        return $this;
    }
}