<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    public function __invoke(Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if ($link->isPasswordProtected()) {
            return redirect()->route('links.unlock', $link->slug);
        }

        $link->redirects()->create();
        return redirect()->away($link->target);
    }

    public function unlockForm(Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if (!$link->isPasswordProtected()) {
            return redirect()->route('links.redirect', $link->slug);
        }

        return view('links.unlock', [
            'link' => $link,
        ]);
    }

    public function unlock(Request $request, Link $link)
    {
        if ($link->isExpired()) {
            abort(404);
        }

        if (!$link->isPasswordProtected()) {
            return redirect()->route('links.redirect', $link->slug);
        }

        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Hash::check($request->input('password'), $link->password_hash)) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ])->withInput();
        }

        // Successful unlock: count the redirect and send user to the target immediately.
        $link->redirects()->create();
        return redirect()->away($link->target);
    }
}
