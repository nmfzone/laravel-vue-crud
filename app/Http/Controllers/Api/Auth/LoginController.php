<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Exception\BadResponseException;
use App\Http\Controllers\Api\BaseApiController;

class LoginController extends BaseApiController
{
    const REFRESH_TOKEN = 'refresh_token';

    protected $database;

    protected $cookie;

    protected $config;

    protected $errorMessage = 'The credentials not found in our database.';

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $this->credentials($request);

        if (! $this->checkUser($credentials)) {
            return $this->sendFailedLoginResponse();
        }

        return $this->access('password', $credentials);
    }

    /**
     * Handle a refresh token request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function refreshToken(Request $request)
    {
        return $this->access('refresh_token', [
            'refresh_token' => $request->cookie(self::REFRESH_TOKEN),
        ]);
    }

    /**
     * Send request to the laravel passport.
     *
     * @param  string  $grantType
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */
    private function access($grantType, array $data = [])
    {
        try {
            $data = array_merge([
                'username'      => $data['email'],
                'client_id'     => config('secrets.client_id'),
                'client_secret' => config('secrets.client_secret'),
                'grant_type'    => $grantType,
            ], $data);

            $http = new Client();

            $guzzleResponse = $http->post(config('app.url').'/oauth/token', [
                'form_params' => $data,
            ]);
        } catch (BadResponseException $e) {
            $guzzleResponse = $e->getResponse();
        }

        $response = json_decode($guzzleResponse->getBody());

        if (! is_null($response) && property_exists($response, "access_token")) {
            Cookie::queue(
                self::REFRESH_TOKEN,
                $response->refresh_token,
                $response->expires_in,
                null,
                null,
                false,
                true
            );

            $response = [
                'token_type'    => $response->token_type,
                'expires_in'    => $response->expires_in,
                'access_token'   => $response->access_token,
            ];
        }

        $response = response()->json($response);
        $response->setStatusCode($guzzleResponse->getStatusCode());

        $headers = $guzzleResponse->getHeaders();
        foreach ($headers as $headerType => $headerValue) {
            $response->header($headerType, $headerValue);
        }

        return $response;
    }

    /**
     * Check the given user credentials.
     *
     * @param  array  $credentials
     * @return boolean
     */
    protected function checkUser(array $credentials)
    {
        $user = User::whereEmail($credentials['email'])->first();

        return ! is_null($user) && Hash::check($credentials['password'], $user->password);
    }

    /**
     * Get the failed login response instance.
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginResponse()
    {
        return response()->json([
            'message' => $this->errorMessage,
        ], 401);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Logout user from the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $accessToken = $request->user()->token();

        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();

        Cookie::queue(Cookie::forget(self::REFRESH_TOKEN));

        return response()->json([
            'message' => 'You have successfully logged out from the app.',
        ]);
    }
}
