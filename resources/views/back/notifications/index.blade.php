@extends('back.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> Notifikasi</h4>
    {{-- <h1>Notifikasi untuk {{ $email }}</h1> --}}
    <div class="card">
        <div class="container m-2">
            <div class="row">
                <div class="demo-inline-spacing mb-3 mr-2">
                    <ul class="list-group">
                        @foreach($notifications as $notification)
                        <a href="{{route('notifications.markAsRead', ['email' => $email, 'id' => $notification->id])}}" class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $notification->created_at->format('d M Y H:i'). " | ".$notification->data['message'] }}
                                {{-- <a href="{{route('notifications.markAsRead', ['email' => $email, 'id' => $notification->id])}}">Lihat</a> --}}
                                @if(is_null($notification->read_at))
                                    <span class="badge bg-danger">Belum Dibaca</span>
                                @else   
                                    {{-- <span class="badge bg-success">2</span> --}}
                                    <span class="badge bg-success">Sudah Dibaca</span>
                                @endif
                            {{-- </div> --}}
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection