<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();


        $responseData = UserResource::collection($users);

        return response()->json(["message" => "", "data" => $responseData]);

    }

    public function create(CreateUserRequest $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->password = bcrypt($data["password"]);
        $user->save();

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User created", "data" => $responseData]);

    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $user->name = $data["name"];
        $user->email = $data["email"];

        if (isset($data["password"])) {
            $user->password = bcrypt($data["password"]);

        }

        $user->save();

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User updated", "data" => $responseData]);
    }

    public function delete(Request $request, User $user)
    {
        $user->tokens()->delete();

        $user->delete();

        return response()->json(["message" => "User deleted"]);
    }
}
