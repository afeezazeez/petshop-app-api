<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;


class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\POST(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="email",description="User Email",type="string"),
     *                 @OA\Property(property="password",description="User password",type="string"),
     *                 required={"email", "password"}
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

    public function store(LoginRequest $request): JsonResponse
    {
        $data = $this->authService->login($request->validated());

        return successResponse($data);
    }


}