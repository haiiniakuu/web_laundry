<x-layouts.app :page="'reports'">
    <x-partials.page-header title="Laporan" :breadcrumbs="[['label' => 'Laporan']]" />

    <main>
        <div class="p-4 mx-auto max-w-7xl md:p-6">

            <!-- Debug tanggal yang diterima -->
            <div class="mb-4">
                <p>Debug Start Date: <strong>{{ $startDate }}</strong></p>
                <p>Debug End Date: <strong>{{ $endDate }}</strong></p>
            </div>

            <!-- Filter Section -->
            <div
                class="flex flex-wrap items-center justify-between p-4 bg-white rounded-md shadow-sm mb-6 dark:border-gray-700 dark:bg-gray-900 text-gray-800 dark:text-white/90">
                <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap items-center gap-3">
                    <!-- Start Date -->
                    <input id="startDate" type="text" name="start_date"
                        class="datepicker rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-blue-200 focus:ring-opacity-50 dark:text-white/90"
                        placeholder="Pilih tanggal mulai" value="{{ $startDate }}" autocomplete="off" />
                    <!-- End Date -->
                    <input id="endDate" type="text" name="end_date"
                        class="datepicker rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-blue-200 focus:ring-opacity-50 dark:text-white/90"
                        placeholder="Pilih tanggal akhir" value="{{ $endDate }}" autocomplete="off" />
                    <!-- Button -->
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-md bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                        Filter
                    </button>
                </form>
                <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                    target="_blank" class="px-4 py-2 bg-brand-500 text-white rounded hover:bg-blue-700 no-print">
                    Print
                </a>

            </div>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6 text-gray-800 dark:text-white/90">
                <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pendapatan</p>
                    <p class="mt-1 text-xl font-bold text-green-600">Rp. {{ number_format($totalRevenue, 0, ',', '.') }}
                    </p>
                </div>
                <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Order</p>
                    <p class="mt-1 text-xl font-bold text-blue-600">{{ $totalOrders }}</p>
                </div>
                <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Order Selesai</p>
                    <p class="mt-1 text-xl font-bold text-green-600">{{ $completedOrders }}</p>
                </div>
                <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Order Pending</p>
                    <p class="mt-1 text-xl font-bold text-yellow-500">{{ $pendingOrders }}</p>
                </div>
            </div>

            <!-- Tabel Transaksi -->
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Kode Order
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Customer
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Tanggal Order
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Estimasi Selesai
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Layanan
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Total
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">{{ $order->order_code }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                    {{ $order->customer->customer_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                    {{ $order->order_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                    {{ $order->order_end_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">
                                    @foreach ($order->transOrderDetails as $detail)
                                        <div>{{ $detail->typeOfService->service_name }} ({{ $detail->qty }}kg)</div>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-white/90">Rp
                                    {{ number_format($order->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium
                                        @if ($order->order_status === 1) bg-green-100 text-green-700
                                        @else bg-yellow-100 text-yellow-700 @endif">
                                        {{ $order->status_text }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- Flatpickr CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#startDate", {
            dateFormat: "Y-m-d",
            allowInput: true,
        });
        flatpickr("#endDate", {
            dateFormat: "Y-m-d",
            allowInput: true,
        });
    </script>
</x-layouts.app>
