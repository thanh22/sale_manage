<?php

namespace App\Http\Requests\Api\User;

use App\Http\Requests\Common\ApiFormRequestTrait;
use App\Http\Requests\User\CreateUserRequest;

class ApiCreateUserRequest extends CreateUserRequest
{
    use ApiFormRequestTrait;
}
