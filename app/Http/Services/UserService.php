<?php

namespace App\Http\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $parameters)
    {
        $user = User::where('email', $parameters['email'])->first();
        if ($user === null)
            throw new \Exception('Wrong email or password');

        if (!Hash::check($parameters['password'], $user->password))
            throw new \Exception('Wrong Password');

        auth()->login($user);
        return $user;
    }

    public function register(array $parameters)
    {
        $data = [
            'name' => $parameters['name'],
            'surname' => $parameters['surname'],
            'phone' => $parameters['phone'],
            'email' => $parameters['email'],
            'password' => bcrypt($parameters['password']),

        ];
        return $this->userRepository->createData($data);
    }

    public function show($id)
    {
        return $this->userRepository->getById($id);
    }

    public function update($id, array $parameters)
    {
        if ($id != Auth::id()) {
            throw new \Exception('No permission');
        }
        $data = [
            'name' => $parameters['name'],
            'surname' => $parameters['surname'],
            'phone' => $parameters['phone'],
            'image' => $parameters['image']->storeAs('uploads', time() . '_' . $parameters['image']->getClientOriginalName(), 'public') ?? ''
        ];
        return $this->userRepository->updateData($id, $data);
    }

    public function deactivate($id)
    {
        if ($id !== Auth::user()->id) {
            throw new \Exception('No permission');
        }
        $this->userRepository->deleteById($id);

    }

    public function changePassword(array $parameters)
    {
        if (!Hash::check($parameters['old_password'], auth()->user()->password)) {
            throw new \Exception(__('Wrong Password'));
        }
        $data = [
            'password' => bcrypt($parameters['password']),
        ];
        return $this->userRepository->updateData(auth()->user()->id, $data);

    }

    public function forgotPassword(array $parameters)
    {
        $user = User::where('email', $parameters['email'])->first();
        if (!$user) {
            throw new \Exception('No Mail');
        }
        $this->userRepository->forgotPassword($user);
    }

    public function resetPassword(array $parameters)
    {
        $user = User::where('id', ($parameters['q'] / 4))->where('remember_token', $parameters['k'])->first();
        if ($user === null) {
            throw new \Exception(__('User Not Found'));
        }
        $data = [
            'password' => $parameters['password'],
            'remember_token' => null
        ];
        return $this->userRepository->updateData(auth()->user()->id, $data);

    }

    public function userDashboard($user_id)
    {
        $pets = $this->userRepository->getüğişUsersPets($user_id);
        return $pets;
    }
}
