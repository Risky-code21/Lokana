<?php

namespace App\Http\Controllers;

// Memastikan abstract class controller disini menngimplementasikan hal - hal penting yang ada di bawah ini
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
