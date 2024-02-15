<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];

    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function storeArray(array $data)
    {
        return $this->makeModel()->insert($data);
    }
}
