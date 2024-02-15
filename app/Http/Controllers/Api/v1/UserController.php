<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\ApiCreateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Services\UserService;

class UserController extends Controller
{
    public $successStatus = 200;

    /**
     * @var mixed
     */
    protected $clientId;

    /**
     * @var mixed
     */
    protected $clientSecret;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(
        UserService $userService
    ) {
        $this->clientId     = env('CLIENT_ID', '');
        $this->clientSecret = env('CLIENT_SECRET', '');
        $this->userService  = $userService;
    }

    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {dd('asdf');
        if (Auth::attempt(
            [
                'email' => request('email'),
                'password' => request('password')
            ]
        )) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;

            return response()->json(
                [
                    'success' => $success
                ],
                $this->successStatus
            );
        }
        else {
            return response()->json(
                [
                    'error' => 'Unauthorised'
                ], 401);
        }
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(ApiCreateUserRequest $request)
    {
        $response = $this->userService->create($request->all());
        if (!$response['status']) {
            return response()->json(['msg' => $response['message']], CODE_INTERNAL_SERVER_ERROR);
        }

        return response()->json(['data' => $response['data']], CODE_SUCCESS);
        // $validator = Validator::make($request->all(),
        //     [
        //         'name' => 'required',
        //         'email' => 'required|email',
        //         'password' => 'required',
        //         'c_password' => 'required|same:password',
        //     ]
        // );

        // if ($validator->fails()) {
        //     return response()->json(
        //         [
        //             'error' => $validator->errors()
        //         ], 401);
        // }

        // $input = $request->all();
        // $input['password'] = bcrypt($input['password']);
        // $user = User::create($input);
        // $success['token'] = $user->createToken('MyApp')->accessToken;
        // $success['name'] = $user->name;

        // return response()->json(
        //     [
        //         'success' => $success
        //     ],
        //     $this->successStatus
        // );
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();

        return response()->json(
            [
                'success' => $user
            ],
            $this->successStatus
        );
    }
}
