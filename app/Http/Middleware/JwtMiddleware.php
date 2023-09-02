<?php

namespace App\Http\Middleware;

use App\Models\JwtToken;
use App\Models\User;
use App\Traits\JwtTokenHelper;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Response;


class JwtMiddleware
{
    use JwtTokenHelper;

    /**
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        // Check for the presence of the Authorization header
        if (!$request->hasHeader('Authorization')) {
            throw new AuthenticationException("Unauthorized");
        }

        $token = $request->bearerToken();

        try {

            $uuid = $this->decodeToken($token);
            $user = User::find($uuid);


            $jwt_token = JwtToken::where('user_id', $user->id)
                ->where('token_title', 'access_token')
                ->first();

            if (!$user || !$jwt_token) {
                throw new AuthenticationException("Unauthorized");
            }


            if ($jwt_token->expired_at->lt(now())){
                $jwt_token->delete();
                throw new AuthenticationException("Unauthorized");
            }

            $uri = $request->getPathInfo();

            if (str_starts_with($uri, 'api/v1/admin')) {
                // This is an admin route
                if (!$user->is_admin) {
                    throw new UnauthorizedHttpException("Unauthorized");
                }
            } elseif (str_starts_with($uri, 'api/v1/user')) {

                // This is a user route
                if ($user->is_admin) {
                    throw new UnauthorizedHttpException("Unauthorized");
                }
            }

        } catch (\Exception $e) {

            throw new UnauthorizedHttpException("Unauthorized");

        }

        return $next($request);

    }
}
