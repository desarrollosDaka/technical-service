<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Http\Response as HttpResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

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
    public function success(mixed $data, int $status = Response::HTTP_OK, array $headers = []): HttpResponse
    {
        $dataResponse = $data;

        if (is_array($data)) {
            $dataResponse = !isset($data['data'])
                ? [
                    'success' => true,
                    'data' => $data,
                ] : $data;
        } else if ($data instanceof Model || $data instanceof MediaCollection || $data instanceof Collection) {
            $dataResponse = [
                'success' => true,
                'data' => $data->toArray(),
            ];
        }

        return response(
            content: $dataResponse,
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
    public function error(string|array $message, int $status = Response::HTTP_BAD_REQUEST, array $headers = []): HttpResponse
    {
        return response(
            content: is_array($message) ? $message : [
                'data' => $message,
                'success' => false,
            ],
            status: $status,
            headers: array_merge(['Content-Type' => 'application/json'], $headers)
        );
    }
}
