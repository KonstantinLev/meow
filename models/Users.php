<?php

/**
 * Created by PhpStorm.
 * User: Konstantin
 * Date: 06.06.2017
 * Time: 21:15
 */

require_once 'BaseModels.php';

class Users extends BaseModels
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function getAllUsers()
    {
        return $this->transform($this->getAll('login'));
    }

    protected function transformElement($user)
    {
        $user['link'] = $this->url->user($user['id_user']);
        return $user;
    }
}