<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = [
                'name' => ($request['name']),
                'email' => ($request['email']),
                'password' => Hash::make($request['password']),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ];
            dd($data);
            $user = $this->userRepository->create($data);

            DB::commit();

            return [
                'success' => true,
                'data' => $user
            ];
        } catch (\Exception $ex) {
            Log::error("create user error " . $ex->getFile() . ' ' . $ex->getLine() . ' ' . $ex->getMessage());
            Log::error('user data', $request);
            DB::rollBack();
            return [
                'status'    => false,
                'message'   => 'Create user error ' . $ex->getMessage()
            ];
        }
    }
}