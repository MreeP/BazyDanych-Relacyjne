<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

/**
 * Class ApiController
 *
 * Base controller for the application api routes.
 */
abstract class ApiController extends Controller
{

    /**
     * Return a JSON response.
     *
     * @param  string $message
     * @param  array  $data
     * @param  int    $status
     * @return JsonResponse
     */
    protected function api(string $message, array $data, int $status)
    {
        return Response::json([
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ], $status);
    }

    /**
     * Return a JSON response with a 200 status code.
     *
     * @param  array $data
     * @return JsonResponse
     */
    protected function ok(array $data = [])
    {
        return $this->api('OK', $data, 200);
    }

    /**
     * Return a JSON response on success.
     *
     * @param  string $message
     * @param  array  $data
     * @param  int    $status
     * @return JsonResponse
     */
    protected function success(string $message, array $data, int $status = 200)
    {
        return $this->api($message, $data, $status);
    }

    /**
     * Return a JSON response on error.
     *
     * @param        $message
     * @param  array $data
     * @param  int   $status
     * @return JsonResponse
     */
    protected function error($message, array $data, int $status)
    {
        return $this->api($message, $data, $status);
    }
}
