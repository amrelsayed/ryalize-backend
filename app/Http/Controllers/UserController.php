<?php

namespace App\Http\Controllers;

use App\Actions\User\CreateUserAction;
use App\Actions\User\DeleteUserAction;
use App\Actions\User\UpdateUserAction;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('transactions')->get();

        $responseData = UserResource::collection($users);

        return response()->json(["message" => "", "data" => $responseData]);

    }

    public function create(CreateUserRequest $request, CreateUserAction $createUserAction)
    {
        $validatedData = $request->validated();

        $user = $createUserAction->execute($validatedData);

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User created", "data" => $responseData]);
    }

    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction)
    {
        $validatedData = $request->validated();

        $user = $updateUserAction->execute($user, $validatedData);

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User updated", "data" => $responseData]);
    }

    public function delete(Request $request, User $user, DeleteUserAction $deleteUserAction)
    {
        $deleteUserAction->execute($user);

        return response()->json(["message" => "User deleted"]);
    }
}
