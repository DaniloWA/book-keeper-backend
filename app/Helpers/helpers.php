<?php

use Illuminate\Http\Request;

if (!function_exists('getToken')) {
    /**
     * Retrieves the API token from the session.
     *
     * @return string The API token.
     */
    function getToken()
    {
        $token = session('api_token');
        return $token;
    }
}

if (!function_exists('getNewToken')) {
    /**
     * Generates a new token for the authenticated user.
     *
     * @param Request $request The request object.
     * @return string The generated token.
     */
    function getNewToken(Request $request)
    {
        $yearInMinutes = 525600;
        $token = $request->user()->createToken("default_token", ['*'], now()->addMinutes($yearInMinutes))->plainTextToken;

        if (!session()->has('api_token')) {
            session(['api_token' => $token]);
        }

        return $token;
    }
}

if (!function_exists('hasUserToken')) {
    /**
     * Checks if the user has a token.
     *
     * @param Request $request The request object.
     * @return mixed The user token.
     */
    function hasUserToken(Request $request)
    {
        $token = getToken();

        if ($token == null) {
            $token = getNewToken($request);
        }

        return $token;
    }
}
