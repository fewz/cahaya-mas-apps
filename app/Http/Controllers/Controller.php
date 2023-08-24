<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function createSuccessMessage($payload, $statusCode = 200, $message = '')
    {
        $result = [
            "payload" => ($payload == "") ? null : $payload,
            "error_msg" => $message,
            "code" => $statusCode
        ];
        return Response::json($result);
    }
}
