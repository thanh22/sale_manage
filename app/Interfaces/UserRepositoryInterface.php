<?php

namespace App\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function storeArray(array $data);
}

