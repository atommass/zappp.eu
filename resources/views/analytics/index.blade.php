<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(!$selectedLink)
                        <p class="text-sm text-gray-600 dark:text-gray-300">You don’t have any links yet. Create a link to see analytics.</p>
                    @else
                        <div class="mb-6">
                            <label for="link_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select link</label>
                            <form method="GET" action="{{ route('analytics') }}" class="mt-2">
                                <select id="link_id" name="link_id" class="w-full max-w-xl p-2 border border-gray-300 dark:border-gray-600 dark:text-gray-800 rounded-lg" onchange="this.form.submit()">
                                    @foreach($links as $link)
                                        <option value="{{ $link->id }}" @selected($selectedLink && $selectedLink->id === $link->id)>
                                            {{ $link->slug }}
                                        </option>
                                    @endforeach
                                </select>
                                <noscript>
                                    <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</button>
                                </noscript>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Countries</h3>
                                <canvas id="countriesChart" height="180"></canvas>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Devices</h3>
                                <canvas id="devicesChart" height="180"></canvas>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Referrers</h3>
                                <canvas id="referrersChart" height="180"></canvas>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-900/30 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Clicks (last 30 days)</h3>
                                <canvas id="timeChart" height="180"></canvas>
                            </div>
                        </div>

                        <div
                            id="analyticsData"
                            class="hidden"
                            data-countries="{{ json_encode($countries) }}"
                            data-devices="{{ json_encode($devices) }}"
                            data-referrers="{{ json_encode($referrers) }}"
                            data-time-series="{{ json_encode($timeSeries) }}"
                        ></div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
                        <script>
                            const dataEl = document.getElementById('analyticsData');
                            const countries = JSON.parse(dataEl?.dataset.countries || '[]');
                            const devices = JSON.parse(dataEl?.dataset.devices || '[]');
                            const referrers = JSON.parse(dataEl?.dataset.referrers || '[]');
                            const timeSeries = JSON.parse(dataEl?.dataset.timeSeries || '{"labels":[],"values":[]}');

                            function toLabels(data) { return (data || []).map(x => x.label); }
                            function toValues(data) { return (data || []).map(x => x.value); }

                            const commonOptions = {
                                responsive: true,
                                plugins: {
                                    legend: { display: false }
                                }
                            };

                            new Chart(document.getElementById('countriesChart'), {
                                type: 'bar',
                                data: {
                                    labels: toLabels(countries),
                                    datasets: [{
                                        label: 'Clicks',
                                        data: toValues(countries),
                                    }]
                                },
                                options: commonOptions
                            });

                            new Chart(document.getElementById('devicesChart'), {
                                type: 'doughnut',
                                data: {
                                    labels: toLabels(devices),
                                    datasets: [{
                                        label: 'Clicks',
                                        data: toValues(devices),
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: { position: 'bottom' }
                                    }
                                }
                            });

                            new Chart(document.getElementById('referrersChart'), {
                                type: 'bar',
                                data: {
                                    labels: toLabels(referrers),
                                    datasets: [{
                                        label: 'Clicks',
                                        data: toValues(referrers),
                                    }]
                                },
                                options: commonOptions
                            });

                            new Chart(document.getElementById('timeChart'), {
                                type: 'line',
                                data: {
                                    labels: (timeSeries && timeSeries.labels) ? timeSeries.labels : [],
                                    datasets: [{
                                        label: 'Clicks',
                                        data: (timeSeries && timeSeries.values) ? timeSeries.values : [],
                                        tension: 0.25,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: { display: false }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: { precision: 0 }
                                        }
                                    }
                                }
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
