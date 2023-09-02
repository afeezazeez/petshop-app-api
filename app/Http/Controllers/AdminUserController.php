<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CreateAdminRequest;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;


class AdminUserController extends Controller
{

    private AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @OA\POST(
     *     path="/api/v1/admin/create",
     *     tags={"Admin Api Endpoints"},
     *     summary="Create admin acccount",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *                 type="object",
     *                @OA\Property(property="first_name",description="User firstname Email",type="string"),
     *                 @OA\Property(property="last_name",description="User lastname",type="string"),
     *                 @OA\Property(property="email",description="User Email",type="string"),
     *                 @OA\Property(property="password",description="User password",type="string"),
     *                 @OA\Property(property="password_confirmation",description="User password",type="string"),
     *                 @OA\Property(property="avatar",description="Avatar image UUID",type="string"),
     *                 @OA\Property(property="address",description="User main address",type="string"),
     *                 @OA\Property(property="phone_number",description="User main  phone number",type="string"),
     *                 @OA\Property(property="marketing",description="User marketing preferences",type="string"),
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

    public function store(CreateAdminRequest $request): JsonResponse
    {
        $data = $this->adminService->createAdmin($request->validated());

        return successResponse($data);
    }
}

