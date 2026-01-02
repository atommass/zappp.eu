<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $links = $user->links()
            ->orderByDesc('created_at')
            ->get(['id', 'slug', 'target', 'created_at']);

        $selectedLink = null;
        $selectedLinkId = $request->query('link_id');

        if ($selectedLinkId) {
            $selectedLink = $links->firstWhere('id', (int) $selectedLinkId);
        }

        if (!$selectedLink) {
            $selectedLink = $links->first();
        }

        if (!$selectedLink) {
            return view('analytics.index', [
                'links' => $links,
                'selectedLink' => null,
                'countries' => [],
                'devices' => [],
                'referrers' => [],
                'timeSeries' => [
                    'labels' => [],
                    'values' => [],
                ],
            ]);
        }

        $redirects = DB::table('redirects')->where('link_id', $selectedLink->id);

        $countries = (clone $redirects)
            ->selectRaw("COALESCE(NULLIF(country_code, ''), 'Unknown') as label, COUNT(*) as value")
            ->groupBy('label')
            ->orderByDesc('value')
            ->get()
            ->toArray();

        $devices = (clone $redirects)
            ->selectRaw("COALESCE(NULLIF(device_type, ''), 'Unknown') as label, COUNT(*) as value")
            ->groupBy('label')
            ->orderByDesc('value')
            ->get()
            ->toArray();

        $referrers = (clone $redirects)
            ->selectRaw("COALESCE(NULLIF(referrer_host, ''), 'Direct') as label, COUNT(*) as value")
            ->groupBy('label')
            ->orderByDesc('value')
            ->get()
            ->toArray();

        $start = Carbon::now()->subDays(29)->startOfDay();
        $end = Carbon::now()->endOfDay();

        $rawSeries = (clone $redirects)
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as clicks')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('clicks', 'day');

        $labels = [];
        $values = [];

        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $key = $d->toDateString();
            $labels[] = $d->format('M j');
            $values[] = (int) ($rawSeries[$key] ?? 0);
        }

        return view('analytics.index', [
            'links' => $links,
            'selectedLink' => $selectedLink,
            'countries' => $countries,
            'devices' => $devices,
            'referrers' => $referrers,
            'timeSeries' => [
                'labels' => $labels,
                'values' => $values,
            ],
        ]);
    }
}
