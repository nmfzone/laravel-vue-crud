<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller as BaseController;

class BaseApiController extends BaseController
{
    /**
     * Send json response with HTTP Code 200.
     *
     * @param  string|array  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ok($data = [])
    {
        return response()->json($data);
    }

    /**
     * Send json response when model deleted.
     *
     * @param  string  $key
     * @param  string  $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function modelDeleted($key = 'id', $message = null)
    {
        $key = ($key == 'id') ? 'given id' : $key;
        $message = $message ?: "The {$key} has been deleted from our database.";

        return $this->ok([
            'message' => $message,
        ]);
    }

    /**
     * Create the response for when a request fails validation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function buildFailedValidationResponse(Request $request, array $errors)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return new JsonResponse($errors, 422);
        }

        return redirect()->to($this->getRedirectUrl())
            ->withInput($request->input())
            ->withErrors($errors, $this->errorBag());
    }
}
