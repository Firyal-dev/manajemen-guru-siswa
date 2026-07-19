<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class FallbackController extends Controller
{
    public function __invoke()
    {
        return redirect(Auth::check() ? route('dashboard') : route('login'));
    }
}
