<?php

namespace App\Http\Controllers\API;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DashBoardResource;
use App\Http\Resources\PetResource;
use App\Http\Resources\UserPetResource;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    private UserService $userService;
    private SuccessResponse $successResponse;
    private FailResponse $failResponse;

    public function __construct(
        UserService     $userService,
        SuccessResponse $successResponse,
        FailResponse    $failResponse,
    )
    {
        $this->userService = $userService;
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
    }

    public function login(Request $request)
    {
        try {
            $user = $this->userService->login($request->only(['email', 'password'])
            );
            return $this->successResponse->setData([
                'user' => new UserResource($user),
                'token' => $user->createToken('user')->accessToken
            ])->setMessages(
                Lang::get('Successfully logged in '),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function register(Request $request)
    {
        try {
            return $this->successResponse->setData([
                'user' => new UserResource($this->userService->register($request->all())),
            ])->setMessages(
                Lang::get('User Registered Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'messages' => $e->getMessage(),
            ])->send();
        }
    }


    public function update(Request $request)
    {
        try {
            $id = auth()->user()->id;
            $user = $this->userService->update($id, $request->all());
            return $this->successResponse->setData([
                'user' => new UserResource($user)
            ])->setMessages(
                Lang::get('User Updated Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function deactivate($id)
    {
        try {
            $this->userService->deactivate($id);
            return $this->successResponse->setMessages(
                Lang::get('User Deactivated Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function show()
    {
        try {
            return $this->successResponse->setData([
                'user' => new UserResource($this->userService->show(auth()->user()->id))
            ])->setMessages(
                Lang::get('User Listed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $this->userService->forgotPassword($request->only(['email']));
            return $this->successResponse->setMessages(
                Lang::get('Request Submitted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $this->userService->resetPassword($request->only(['email']));
            return $this->successResponse->setMessages(
                Lang::get('Request Submitted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function dashBoard()
    {
        try {
            return $this->successResponse->setData([
                'dashboard' => PetResource::collection($this->userService->userDashboard(auth()->user()->id))
            ])->setMessages(
                Lang::get('Dashboard Showed Successfully'),
            )->send();
        } catch (\Exception $e) {
            dd($e);
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }


}
