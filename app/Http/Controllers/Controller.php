<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function responseData(array $data = [], int $status = 200, array $headers = [], $options = 0) {
        return response()->json($data, $status, $headers, $options);
    }
}
