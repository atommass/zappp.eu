<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class RedirectController extends Controller
{
    public function __invoke(Link $link)
    {
        $link->redirects()->create();
        return redirect()->away($link->target);
    }
}
