<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserLoginResource;
use App\Http\Resources\UserRegisterResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\{Facades\Hash,Str};
use App\Models\User;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request -> validated();
        // jika username sudah ada maka di tolak 
        if(User::where('username',$data['username'])->count() == 1){
            throw  new HttpResponseException(response(
            [
                "errors"=>[
                    "username"=>"username already to exists"
                ]
            ],400));
        }

        // buat user baru 
        $user = new User($data);
        $user -> password = Hash::make($data["password"]);
        // buat token
        $user -> token = Str::uuid()->toString();
        $user -> save();
        // kembalikan respon success
        return (new UserRegisterResource($user)) 
        -> response()->setStatusCode(201);
    }

    public function login(UserLoginRequest $request): UserLoginResource 
    {
        $data = $request -> validated();
        // cari akun berdasarkan username
        $user = User::where("username",$data["username"])->first();
        // cek password 
        if(!$user || !Hash::check($data["password"],$user->password)){
            throw new HttpResponseException(response([
                "errors"=>[
                    "message"=>"username or password wrong"
                ]
            ],401)); 
        }
        // buat token
        $user -> token = Str::uuid()->toString();
        $user -> save();

        return new UserLoginResource($user); // 200

    }

    public function update(UserUpdateRequest $request): JsonResponse
    {
        $data = $request -> validated();

        if(!empty($data['image'])){
          
        }
    }

    // get current user

    public function current(): string
    {
        return "user";
    }

    // logout

}
