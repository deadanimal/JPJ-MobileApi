<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *	version="1.0",
 *	title="My JPJ API Documentation",
 *	description="API list for My JPJ.",
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
	 * @OA\SecurityScheme(
	 *	type="apiKey",
	 *	in="header",
	 *	securityScheme="api_key",
	 *	name="Authorization"
	 * )
	 * @OA\SecurityScheme(
	 *	type="apiKey",
	 *	in="header",
	 *	securityScheme="open_key",
	 *	name="OpenKey"
	 * )
	 */
}
