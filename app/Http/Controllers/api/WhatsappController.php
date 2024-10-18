<?php

namespace App\Http\Controllers\api;

//import model 
use App\Models\Whatsapp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//import resource KonsultasiResource
use App\Http\Resources\WhatsappResource;

class WhatsappController extends Controller
{
    //get message wa staus =0
    public function getDaftarKirim(){
        $message=Whatsapp::where('status',0)->take(2)->get();
        return new WhatsappResource(true, 'Daftar message', $message);
    }
    
    //set Read status=1
    public function setReadNotifWA($id){
        $message=Whatsapp::where('id',$id)->first();
        $message->update([
                    'status'     => 1
        ]);

        return new WhatsappResource(true, 'Daftar message', $message);
    }
}
