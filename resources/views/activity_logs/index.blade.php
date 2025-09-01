@extends('layouts.master')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4 dark:text-white">📜 Log Aktivitas</h2>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">#</th>
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
                    @forelse($logs as $index => $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300">{{ $logs->firstItem() + $index }}
                            </td>
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
                            <td colspan="7" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada data log aktivitas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
