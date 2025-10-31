<?php

if (!function_exists('responseApi')) {
    function responseApi()
    {
        return app(\App\Responses\ResponseService::class);
    }
}
