<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LinkController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('dashboard', [
            'links' => $user->links()
                ->latest()
                ->withCount('redirects')
                ->paginate(5),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'target' => 'required|url|max:2048',
            'slug' => 'nullable|string|alpha_dash|max:255|unique:links,slug',
            'expires_at' => 'nullable|date',
            'never' => 'nullable|boolean',
        ], [
            'target.required' => 'Please enter a URL to shorten.',
            'target.url' => 'Please enter a valid URL.',
            'slug.unique' => 'This link is already taken. Try another one.',
            'slug.alpha_dash' => 'Link can only contain letters, numbers, dashes, and underscores.',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $link = $user->links()->create([
            'target' => $request->input('target'),
            'slug' => $request->input('slug') ?: Str::random(6),
            'expires_at' => (
                $request->boolean('never')
                    ? null
                    : ($request->filled('expires_at') ? Carbon::parse($request->input('expires_at')) : now()->addDays(90))
            ),
        ]);

        return redirect()->route('dashboard')->with('status', 'Link created: ' . url($link->slug));
    }

    public function destroy(\App\Models\Link $link)
    {
        abort_if($link->user_id !== Auth::id(), 403);

        DB::transaction(function () use ($link) {
            $link->redirects()->delete();
            $link->delete();
        });

        return redirect()->route('dashboard')->with('status', 'Link deleted.');
    }
}
