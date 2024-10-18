@foreach ($satker as $item)
  <div class="modal fade" id="modalDelete{{$item->id_satker}}" data-bs-backdrop="static" tabindex="-1">
      <div class="modal-dialog">
        <form action="{{ url('satker/'.$item->id_satker)}}" method="POST" class="modal-content">
          @method('DELETE')
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="backDropModalTitle">Hapus Satuan Kerja {{$item->nama_satker}}</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <p> Apakah anda yakin akan menghapus Satuan Kerja <u> {{ $item->nama_satker}} </u> ?</p>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-danger">Hapus</button>
          </div>
        </form>
      </div>
  </div>
  @endforeach