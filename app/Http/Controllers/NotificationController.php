<?php

namespace App\Http\Controllers;

use App\Models\ProductIn;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function superadminIndex()
    {
        $notifs = ProductIn::where('status', 'menunggu')
            ->latest()
            ->paginate(10);

        return view('notifications.superadmin', compact('notifs'));
    }

    public function adminGudangIndex()
    {
        $notifs = ProductIn::where('requester_name', Auth::user()->name)
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest()
            ->paginate(10);

        // hitung notif belum dibaca
        $unreadCount = ProductIn::where('requester_name', Auth::user()->name)
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->where('is_read', false)
            ->count();

        return view('notifications.admin_gudang', compact('notifs', 'unreadCount'));
    }

    public function showAdminGudang($id)
    {
        $notif = ProductIn::where('requester_name', Auth::user()->name)
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->findOrFail($id);

        // update jadi sudah dibaca
        if (!$notif->is_read) {
            $notif->is_read = true;
            $notif->save();
        }

        return view('notifications.detail_admin_gudang', compact('notif'));
    }
}
