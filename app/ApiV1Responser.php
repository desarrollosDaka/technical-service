<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Http\Response as HttpResponse;

trait ApiV1Responser
{
    /**
     * Success response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return HttpResponse
     */
    public function success(array|Model $data, int $status = Response::HTTP_OK, array $headers = []): HttpResponse
    {
        return response(
            content: [
                'data' => is_array($data) ? $data : $data->toArray()
            ],
            status: $status,
            headers: array_merge(['Content-Type' => 'application/json'], $headers)
        );
    }

    /**
     * Error response
     *
     * @param string $message
     * @param [type] $status
     * @param array $headers
     * @return HttpResponse
     */
    public function error(string $message, int $status = Response::HTTP_BAD_REQUEST, array $headers = []): HttpResponse
    {
        return response(
            content: [
                'data' => $message
            ],
            status: $status,
            headers: array_merge(['Content-Type' => 'application/json'], $headers)
        );
    }
}
