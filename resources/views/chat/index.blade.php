@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Ruang Obrolan</title>
@endsection

@section('content')
    <div class="flex h-[80vh] border rounded-lg overflow-hidden">
        <!-- Sidebar User List -->
        <div class="w-1/4 bg-gray-100 dark:bg-gray-800 p-4 overflow-y-auto">
            <h2 class="font-semibold mb-4">Kontak</h2>
            <ul>
                @forelse ($users as $u)
                    <li class="mb-2 flex items-center justify-between">
                        <a href="{{ route('chat.index', $u->id) }}"
                            class="block flex-1 px-3 py-2 rounded
                   {{ isset($receiver) && $receiver->id === $u->id
                       ? 'bg-blue-600 text-white'
                       : 'hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                            {{ $u->name }} ({{ $u->role }})
                        </a>

                        {{-- Badge jika ada pesan belum dibaca --}}
                        @if ($u->unread_count > 0)
                            <span class="ml-2 bg-red-600 text-white text-xs font-semibold rounded-full px-2 py-0.5">
                                {{ $u->unread_count }}
                            </span>
                        @endif
                    </li>
                @empty
                    <li class="text-gray-500 text-sm">Tidak ada kontak tersedia</li>
                @endforelse
            </ul>
        </div>


        <!-- Chat Window -->
        <div class="flex-1 flex flex-col">
            <div id="chat-window" class="flex-1 p-4 overflow-y-auto bg-white dark:bg-gray-900">
                @if ($receiver)
                    <h3 class="font-semibold mb-4">Chat dengan {{ $receiver->name }} ({{ $receiver->role }})</h3>
                    @foreach ($messages as $msg)
                        <div
                            class="mb-3 flex flex-col {{ $msg->sender_id === auth()->id() ? 'items-end' : 'items-start' }}">
                            {{-- Nama Pengirim --}}
                            <span class="text-xs text-gray-500 mb-1">
                                {{ $msg->sender->name }}
                            </span>

                            {{-- Bubble Chat --}}
                            <div
                                class="p-2 rounded-lg max-w-xs break-words relative
            {{ $msg->sender_id === auth()->id()
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200 dark:bg-gray-700 dark:text-gray-200' }}">

                                {{-- Isi Pesan --}}
                                {{ $msg->message }}

                                {{-- Waktu + Status Ceklis --}}
                                <div
                                    class="flex items-center justify-end mt-1 text-[10px] text-gray-300 dark:text-gray-400">
                                    <span>{{ $msg->created_at->format('H:i') }}</span>

                                    {{-- Tanda Ceklis --}}
                                    @if ($msg->sender_id === auth()->id())
                                        @if ($msg->is_read)
                                            {{-- Ceklis 2 = dibaca --}}
                                            <span class="ml-1 text-blue-400">✓✓</span>
                                        @else
                                            {{-- Ceklis 1 = terkirim --}}
                                            <span class="ml-1">✓</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-500">Pilih kontak untuk mulai chat.</p>
                @endif
            </div>

            @if ($receiver)
                <form action="{{ route('chat.store', $receiver->id) }}" method="POST"
                    class="p-4 bg-gray-100 dark:bg-gray-800">
                    @csrf
                    <div class="flex">
                        <input type="text" name="message"
                            class="flex-1 border rounded-l px-3 py-2 dark:bg-gray-900 dark:text-gray-200"
                            placeholder="Tulis pesan...">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r">Kirim</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function scrollChatToBottom() {
            const chatWindow = document.getElementById("chat-window");
            if (chatWindow) {
                chatWindow.scrollTop = chatWindow.scrollHeight;
            }
        }

        // Scroll otomatis saat halaman selesai load
        document.addEventListener("DOMContentLoaded", scrollChatToBottom);

        // Kalau kamu nanti pakai Echo/Pusher, bisa trigger ini juga tiap ada pesan baru
        window.addEventListener("new-message", scrollChatToBottom);
    </script>
@endpush
