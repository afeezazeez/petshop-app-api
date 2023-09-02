<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\JwtToken;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/user/login",
     *     tags={"User Api Endpoints"},
     *     summary="Login user account",
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

    /**
     * @OA\GET (
     *     path="/api/v1/user/logout",
     *     tags={"User Api Endpoints"},
     *     security={{"bearerAuth":{}}},
     *     summary="Logout user account",
     *     @OA\Response(response=200,description="OK"),
     *     @OA\Response(response=401,description="Unauthorized"),
     *     @OA\Response(response=404,description="Page not found"),
     *     @OA\Response(response=422,description="Unprocessable Entity"),
     *     @OA\Response(response=500,description="Internal server error")
     *
     * )
     */
    public function destroy(): JsonResponse
    {
        JwtToken::where('user_id',auth()->id())->delete();
        return successResponse();
    }


}
