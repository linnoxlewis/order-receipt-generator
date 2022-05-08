<?php

namespace App\Helper;

class ApiResponse
{
    protected const SERVER_ERROR = "Internal server error";

    /**
     * Return success api response
     *
     * @param mixed $data
     *
     * @return array
     */
    public static function successResponse(mixed $data = null): array
    {
        return [
            "success" => true,
            "data" => $data
        ];
    }

    /**
     * Return error api response
     *
     * @param mixed $data
     *
     * @return array
     */
    public static function badRequestResponse(mixed $data): array
    {
        return [
            "success" => false,
            "data" => $data
        ];
    }

    /**
     * Return internal server error api response
     *
     * @return array
     */
    public static function serverErrorResponse()
    {
        return [
            "success" => false,
            "data" => self::SERVER_ERROR
        ];
    }
}