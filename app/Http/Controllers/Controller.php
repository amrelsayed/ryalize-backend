<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(
 *    title="Ryalize Api Docs",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     securityScheme="sanctumAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Add 'Bearer' before your Sanctum token (e.g., 'Bearer YOUR_TOKEN')"
 * )
 */
abstract class Controller
{

}
