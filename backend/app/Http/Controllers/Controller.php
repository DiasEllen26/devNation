<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Server(url="http://localhost:8880/")
 * @OA\Info(title="devNation Routs", version="0.0.1")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
