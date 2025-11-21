<x-layouts.app :page="'dashboard'">
    <x-partials.page-header title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]" />

    <main class="p-4 mx-auto max-w-7xl md:p-6 text-gray-800 dark:text-white/90">

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <!-- Total Customers -->
            <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Customer</p>
                <p class="mt-1 text-xl font-bold text-blue-600">{{ $totalCustomers }}</p>
            </div>

            <!-- Total Services -->
            <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Layanan</p>
                <p class="mt-1 text-xl font-bold text-indigo-600">{{ $totalServices }}</p>
            </div>

            <!-- Total Orders -->
            <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Order</p>
                <p class="mt-1 text-xl font-bold text-green-600">{{ $totalOrders }}</p>
            </div>

            <!-- Revenue This Month -->
            <div class="text-center p-6 border rounded-lg bg-white dark:bg-gray-900">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Pendapatan Bulan Ini</p>
                <p class="mt-1 text-xl font-bold text-emerald-600">Rp. {{ number_format($monthlyRevenue, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <!-- Latest Orders -->
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Order Terbaru</h2>
            <div
                class="overflow-x-auto rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Kode</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Customer</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Tanggal</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Total</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500 dark:text-gray-400">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-800">
                        @forelse ($latestOrders as $order)
                            <tr>
                                <td class="px-6 py-4 text-sm">{{ $order->order_code }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->customer->customer_name }}</td>
                                <td class="px-6 py-4 text-sm">{{ $order->order_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
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
                                <td colspan="5" class="text-center py-4">Tidak ada order terbaru</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
</x-layouts.app>
