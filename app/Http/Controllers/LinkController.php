<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        /** enforce per-user link limit */
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $max = 20;
        if ($user->links()->count() >= $max) {
            return redirect()->route('dashboard')->with('status', "You have reached the maximum of {$max} links. Delete some to create more.");
        }

        $request->validate([
            'target' => 'required|url|max:2048',
            'slug' => 'nullable|string|alpha_dash|max:255|unique:links,slug',
            'expires_at' => 'nullable|date',
            'never' => 'nullable|boolean',
            'password_enabled' => 'nullable|boolean',
            'password' => [
                'nullable',
                'string',
                'min:4',
                'max:255',
                Rule::requiredIf(fn () => $request->boolean('password_enabled')),
            ],
        ], [
            'target.required' => 'Please enter a URL to shorten.',
            'target.url' => 'Please enter a valid URL.',
            'slug.unique' => 'This link is already taken. Try another one.',
            'slug.alpha_dash' => 'Link can only contain letters, numbers, dashes, and underscores.',
        ]);

        // $user already defined above

        $link = $user->links()->create([
            'target' => $request->input('target'),
            'slug' => $request->input('slug') ?: Str::random(6),
            'expires_at' => (
                $request->boolean('never')
                    ? null
                    : ($request->filled('expires_at') ? Carbon::parse($request->input('expires_at')) : now()->addDays(90))
            ),
            'password_hash' => $request->boolean('password_enabled')
                ? Hash::make($request->input('password'))
                : null,
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

    public function edit(\App\Models\Link $link)
    {
        abort_if($link->user_id !== Auth::id(), 403);

        return view('links.edit', [
            'link' => $link,
        ]);
    }

    public function update(Request $request, \App\Models\Link $link)
    {
        abort_if($link->user_id !== Auth::id(), 403);

        $request->validate([
            'target' => 'required|url|max:2048',
            'expires_at' => 'nullable|date',
            'never' => 'nullable|boolean',
            'password_enabled' => 'nullable|boolean',
            'password' => [
                'nullable',
                'string',
                'min:4',
                'max:255',
                Rule::requiredIf(fn () => $request->boolean('password_enabled') && is_null($link->password_hash)),
            ],
        ], [
            'target.required' => 'Please enter a URL to shorten.',
            'target.url' => 'Please enter a valid URL.',
        ]);

        $link->target = $request->input('target');

        if ($request->boolean('never')) {
            $link->expires_at = null;
        } elseif ($request->filled('expires_at')) {
            $link->expires_at = Carbon::parse($request->input('expires_at'));
        }

        if (!$request->boolean('password_enabled')) {
            $link->password_hash = null;
        } elseif ($request->filled('password')) {
            // If enabled and a new password is provided, update it.
            $link->password_hash = Hash::make($request->input('password'));
        }

        $link->save();

        return redirect()->route('dashboard')->with('status', 'Link updated.');
    }
}
