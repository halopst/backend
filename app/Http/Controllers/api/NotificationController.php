<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import model
use App\Models\Notification;
use App\Models\User;

//import resource PetugasResource
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    //
     /**
     * index
     *
     * @return void
     */
    public function index($email)
    {

        $user = User::where('email', $email)->firstOrFail();
        $notifications = $user->notifications;
        return new NotificationResource(true, 'List Data Notifikasi', $notifications);
    }

    public function markAsRead($email, $id)
    {
        // Cari user berdasarkan email
        $user = User::where('email', $email)->firstOrFail();
        $status='';
        
        $notification = $user->notifications()->find($id);
        if ($notification) {
            $notification->markAsRead();
            $status='sukses';
        }else{
            $status='gagal';
        };
        $notificationsUpdate = $user->notifications;
        return response()->json([
            'status' => $status, 
            'notifikasi'=>$notificationsUpdate
        ]);
        // return new NotificationResource(true, 'List Data Notifikasi', $return);
    
    }

    public function unreadCount($email)
    {
        $user = User::where('email', $email)->firstOrFail();
        $unreadCount = $user->unreadNotifications->count();
        return response()->json(['unreadCount' => $unreadCount]);
    }
}
