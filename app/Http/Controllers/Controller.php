<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 *
 * Base controller for the application.
 */
abstract class Controller
{

    use AuthorizesRequests;
}
