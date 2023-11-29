<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function error($content = '', $id = '', $status = null)
    {
        if (empty($status)) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return response()->json(['error' => $content, 'id' => $id], $status);
    }

    protected function response($content = '', $status = null)
    {
        if (empty($status)) {
            $status = Response::HTTP_OK;
        }

        return response()->json(['data' => $content], $status);
    }
}
