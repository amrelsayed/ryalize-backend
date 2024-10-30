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
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="List users",
     *     tags={"User"},
     *     security={{"sanctumAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *     ),
     *     @OA\Response(response=500, description="Internal server error")
     * )
     */
    public function index()
    {
        $users = User::withCount('transactions')->get();

        $responseData = UserResource::collection($users);

        return response()->json(["message" => "", "data" => $responseData]);
    }

    /**
     * @OA\Post(
     *     path="/api/users/",
     *     summary="Create new user",
     *     tags={"User"},
     *     security={{"sanctumAuth": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User data"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function create(CreateUserRequest $request, CreateUserAction $createUserAction)
    {
        $validatedData = $request->validated();

        $user = $createUserAction->execute($validatedData);

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User created", "data" => $responseData]);
    }

    /**
     * @OA\Put(
     *     path="/api/users/{user_id}",
     *     summary="Update user",
     *     tags={"User"},
     *     security={{"sanctumAuth": {}}},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User updated"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $updateUserAction)
    {
        $validatedData = $request->validated();

        $user = $updateUserAction->execute($user, $validatedData);

        $responseData = new UserResource(resource: $user);

        return response()->json(["message" => "User updated", "data" => $responseData]);
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{user_id}",
     *     summary="Delete user",
     *     tags={"User"},
     *     security={{"sanctumAuth": {}}},
     *     @OA\Response(response="200", description="User deleted"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function delete(Request $request, User $user, DeleteUserAction $deleteUserAction)
    {
        $deleteUserAction->execute($user);

        return response()->json(["message" => "User deleted"]);
    }
}
