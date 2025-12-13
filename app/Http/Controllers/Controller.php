<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponse;

/**
 * Base Controller
 * 
 * All controllers extend this base controller
 * Includes ApiResponse trait for unified API responses
 */
abstract class Controller
{
    use ApiResponse;
}
