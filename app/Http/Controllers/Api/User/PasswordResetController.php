<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Services\PasswordResetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{

    private PasswordResetService $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }


    /**
     * @OA\POST(
     *     path="/api/v1/user/forgot-password",
     *     tags={"User Api Endpoints"},
     *     summary="Create a token to reset user password",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="email",description="User Email",type="string"),
     *                 required={"email"}
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


    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        $data = $this->passwordResetService->createToken($request->email);

        return successResponse(['reset_token'=>$data]);
    }
}
