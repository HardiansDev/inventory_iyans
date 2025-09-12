<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Request $request, $receiverId = null)
    {
        $user = Auth::user();

        // Tentukan role yang boleh chat
        $allowedRoles = [];
        if ($user->role === 'superadmin') {
            $allowedRoles = ['admin_gudang'];
        } elseif ($user->role === 'admin_gudang') {
            $allowedRoles = ['superadmin', 'kasir'];
        } elseif ($user->role === 'kasir') {
            $allowedRoles = ['admin_gudang'];
        }

        // Ambil user yang bisa diajak chat + unread count
        $users = User::whereIn('role', $allowedRoles)
            ->where('id', '!=', $user->id)
            ->withCount([
                'messagesSent as unread_count' => function ($query) use ($user) {
                    $query->where('receiver_id', $user->id)
                        ->where('is_read', false);
                }
            ])
            ->get();


        // dd($users->toArray());

        // Default value
        $messages = collect();
        $receiver = null;

        if ($receiverId) {
            $receiver = User::findOrFail($receiverId);

            // Ambil pesan antar user
            $messages = Message::where(function ($q) use ($user, $receiverId) {
                $q->where('sender_id', $user->id)
                    ->where('receiver_id', $receiverId);
            })
                ->orWhere(function ($q) use ($user, $receiverId) {
                    $q->where('sender_id', $receiverId)
                        ->where('receiver_id', $user->id);
                })
                ->orderBy('created_at')
                ->get();

            // Tandai pesan dari receiver sebagai sudah dibaca
            Message::where('sender_id', $receiverId)
                ->where('receiver_id', $user->id)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        return view('chat.index', compact('users', 'messages', 'receiver'));
    }


    public function store(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $receiverId,
            'message'     => $request->message,
            'is_read'     => false, // default belum dibaca
        ]);

        return redirect()->route('chat.index', $receiverId)->with('success', 'Pesan terkirim!');
    }
}
