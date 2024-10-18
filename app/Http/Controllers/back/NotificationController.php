<?php
namespace App\Http\Controllers\back;

// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NotificationPST;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function sendNotification()
    {
        $user = User::where('email','ahmad.arafat@bps.go.id')->first();
        //$user2 = User::find(2);
        $details = [
                'subject'=>'Reservasi Konsultasi',
                'penerima'=>'Pengguna Data',
                'message' => 'Ada Permintaan Notifikasi',
                'action' => url('/')
            ];

        $user->notify(new NotificationPST($details));

    }

    public function index($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $notifications = $user->notifications;
        return view('back.notifications.index', compact('notifications', 'email'));
    }

    public function markAsRead($email, $id)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $email)->firstOrFail();

        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

    public function unreadCount($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        // dd($user);
        // $user = Auth::user();
        $unreadCount = $user->unreadNotifications->count();
        return response()->json(['unreadCount' => $unreadCount]);
    }
}
