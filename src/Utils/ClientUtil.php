<?php
namespace InfraDigital\ApiClient\Utils;

use InfraDigital\ApiClient\Constants\Constants;

class ClientUtil
{
    public function passwordHash($plainPassword)
    {
        return hash('SHA256', (hash('SHA256', $plainPassword) . date('Ymd')));
    }

    public function buildUri($username, $password, $path = '', $query = array(), $isDevMode = false)
    {
        return Constants::URI_PROTOCOL . '://'
            . $username . ':' . $password . '@'
            . (($isDevMode === true) ? Constants::URI_DOMAIN_DEV : Constants::URI_DOMAIN_PROD) . DIRECTORY_SEPARATOR
            . $path
            . (( ! empty($query)) ? '?' . http_build_query($query) : '');
    }
}