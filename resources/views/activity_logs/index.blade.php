@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Log Aktivitas</title>
@endsection

@section('content')
    <div class="p-6">
        <div class="flex flex-wrap items-center justify-between mb-4 gap-3">
            {{-- <h2 class="text-2xl font-bold dark:text-white">
                Log Aktivitas
            </h2> --}}

            <!-- Show Per Page Dropdown -->
            <div class="flex items-center gap-2">

                <select id="showPerPage" name="showPerPage"
                    class="w-auto rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm
                       focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200
                       hover:border-gray-400
                       dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:placeholder-gray-400
                       dark:hover:border-gray-500 dark:focus:border-blue-400 dark:focus:ring-blue-400">

                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">User</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Action</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Description
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">IP Address
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">User Agent
                        </th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">
                                {{ $log->user ? $log->user->name : 'Guest' }}
                            </td>
                            <td class="px-4 py-2 text-sm font-medium text-blue-600 dark:text-blue-400">
                                {{ $log->action }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">
                                {{ $log->description ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">{{ $log->ip_address }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300 truncate max-w-[200px]"
                                title="{{ $log->user_agent }}">
                                {{ \Illuminate\Support\Str::limit($log->user_agent, 40) }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">
                                {{ $log->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada data log aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $logs->appends(request()->query())->links('pagination::tailwind') }}
        </div>
    </div>


    <script>
        document.getElementById('showPerPage').addEventListener('change', function() {
            const perPage = this.value;
            const url = new URL(window.location.href);
            url.searchParams.set('perPage', perPage);
            window.location.href = url.toString();
        });
    </script>
@endsection
