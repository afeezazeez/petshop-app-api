<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\User\AddUserRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @OA\GET (
     *     path="/api/v1/user",
     *     tags={"User Api Endpoints"},
     *     security={{"bearerAuth":{}}},
     *     summary="View a User Account",
     *     @OA\Response(response=200,description="OK"),
     *     @OA\Response(response=401,description="Unauthorized"),
     *     @OA\Response(response=404,description="Page not found"),
     *     @OA\Response(response=422,description="Unprocessable Entity"),
     *     @OA\Response(response=500,description="Internal server error")
     *
     * )
     */
    public function show(): JsonResponse
    {
        return successResponse(auth()->user());
    }



    /**
     * @OA\POST(
     *     path="/api/v1/user/create",
     *     tags={"User Api Endpoints"},
     *     summary="Create user acccount",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                @OA\Property(property="first_name",description="User firstname",type="string"),
     *                 @OA\Property(property="last_name",description="User lastname",type="string"),
     *                 @OA\Property(property="email",description="User Email",type="string"),
     *                 @OA\Property(property="password",description="User password",type="string"),
     *                 @OA\Property(property="password_confirmation",description="User password",type="string"),
     *                 @OA\Property(property="avatar",description="Avatar image UUID",type="string"),
     *                 @OA\Property(property="address",description="User main address",type="string"),
     *                 @OA\Property(property="phone_number",description="User main  phone number",type="string"),
     *                 @OA\Property(property="is_marketing",description="User marketing preferences",type="string"),
     *                 required={"first_name", "last_name","email","password","password_confirmation","avatar","address","phone_number"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(response=200,description="OK"),
     *     @OA\Response(response=401,description="Unauthorized"),
     *     @OA\Response(response=404,description="Page not found"),
     *     @OA\Response(response=422,description="Unprocessable Entity"),
     *     @OA\Response(response=500,description="Internal server error")
     *
     * )
     */

    public function store(AddUserRequest $request): JsonResponse
    {
        $data = $this->userService->createUser($request->validated());

        return successResponse($data);
    }

    /**
     * @OA\PUT(
     *     path="/api/v1/user/edit",
     *     tags={"User Api Endpoints"},
     *     summary="Update a User Account",
     *      security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                @OA\Property(property="first_name",description="User firstname",type="string"),
     *                 @OA\Property(property="last_name",description="User lastname",type="string"),
     *                 @OA\Property(property="email",description="User Email",type="string"),
     *                 @OA\Property(property="password",description="User password",type="string"),
     *                 @OA\Property(property="password_confirmation",description="User password",type="string"),
     *                 @OA\Property(property="avatar",description="Avatar image UUID",type="string"),
     *                 @OA\Property(property="address",description="User main address",type="string"),
     *                 @OA\Property(property="phone_number",description="User main  phone number",type="string"),
     *                 @OA\Property(property="is_marketing",description="User marketing preferences",type="string"),
     *                 required={"first_name", "last_name","email","password","password_confirmation","avatar","address","phone_number"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(response=200,description="OK"),
     *     @OA\Response(response=401,description="Unauthorized"),
     *     @OA\Response(response=404,description="Page not found"),
     *     @OA\Response(response=422,description="Unprocessable Entity"),
     *     @OA\Response(response=500,description="Internal server error")
     *
     * )
     */

    public function update(EditUserRequest $request): JsonResponse
    {
        $data = $this->userService->updateUser($request->validated());

        return successResponse($data);
    }



}
