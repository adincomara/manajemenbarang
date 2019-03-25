@extends('layouts.global')

@section('title') Edit barang @endsection 

@section('content')

<div class="row">
  <div class="col-md-8">

    @if(session('status'))
      <div class="alert alert-success">
        {{session('status')}}
      </div>
    @endif

    <form
      enctype="multipart/form-data"
      method="POST"
      action="{{route('barang.update', ['id' => $barang->id])}}"
      class="p-3 shadow-sm bg-white"
    >

    {{ csrf_field() }} 
    <input type="hidden" name="_method" value="PUT">

    <label for="title">Nama Barang</label><br>
    <input
      type="text"
      class="form-control"
      value="{{$barang->nama}}"
      name="nama"
      placeholder="Nama Barang"
    />
    <br>

    <label for="gambar">Gambar</label><br>
    <small class="text-muted">Gambar Sekarang</small><br>
    @if($barang->gambar)
      <img src="{{asset('storage/' . $barang->gambar)}}" width="96px"/>
    @endif
    <br><br>
    <input 
      type="file" 
      class="form-control"
      name="gambar"
    >
    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
    <br><br>

    <label for="slug">Slug</label><br>
    <input 
      type="text"
      class="form-control"
      value="{{$barang->slug}}"
      name="slug"
      placeholder="enter-a-slug"
    />
    <br>

    {{-- <label for="description">Description</label> <br>
    <textarea name="description" id="description" class="form-control">{{$book->description}}</textarea>
    <br> --}}

    <label for="categories">Categories</label>
    <select multiple class="form-control" name="categories[]" id="categories"></select>
    <br>
    <br>

    <label for="stock">Stock</label><br>
    <input type="text" class="form-control" placeholder="Stock" id="stock" name="stock" value="{{$barang->stock}}">
    <br>

    <label for="spek">Spesifikasi</label>
    <input placeholder="Spesifikasi" value="{{$barang->spek}}" type="text" id="spek" name="spek" class="form-control">
    <br>

    <label for="status_barang">Status Barang</label><br>
    {{-- <input class="form-control" type="text" placeholder="Status Barang" name="status_barang" id="status_barang" value="{{$barang->status_barang}}"> --}}
    <select name="status_barang" class="form-control">
        <option value="Milik Sendiri" {{$barang->status_barang == 'Milik Sendiri' ? 'selected' : ''}} value="Milik Sendiri">Milik Sendiri </option>
        <option value="Titipan" {{$barang->status_barang == 'Titipan' ? 'selected' : ''}} value="Titipan">Titipan</option>
      </select>
    <br>

    <label for="harga">Harga</label><br>
    <input type="text" class="form-control" name="harga" placeholder="Harga" id="harga" value="{{$barang->harga}}">
    <br>

    <label for="">Status</label>
    <select name="status" id="status" class="form-control">
      <option {{$barang->status == 'DIJUAL' ? 'selected' : ''}} value="DIJUAL">DIJUAL</option>
      <option {{$barang->status == 'TIDAK DIJUAL' ? 'selected' : ''}} value="TIDAK DIJUAL">DRAFT</option>
    </select>
    <br>

    <button class="btn btn-primary" value="PUBLISH">Update</button>

    </form>
  </div>
</div>

@endsection

@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script>
$('#categories').select2({
  ajax: {
    url: 'http://localhost:8000/ajax/categories/search',
    processResults: function(data){
      return {
        results: data.map(function(item){return {id: item.id, text: item.name} })
      }
    }
  }
});

var categories = {!! $barang->categories !!}

    categories.forEach(function(category){
      var option = new Option(category.name, category.id, true, true);
      $('#categories').append(option).trigger('change');
    });
</script>
@endsection