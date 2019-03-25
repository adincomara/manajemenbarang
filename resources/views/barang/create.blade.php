@extends('layouts.global')

@section('footer-scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

@section('title') Create barang @endsection 

@section('content')
  <div class="row">
    <div class="col-md-8">
    @if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
    @endif
      <form 
        action="{{route('barang.store')}}"
        method="POST"
        enctype="multipart/form-data"
        class="shadow-sm p-3 bg-white"
        >

        {{ csrf_field() }}

        <label for="Nama">Nama</label> <br>
        <input type="text" class="form-control" name="nama" placeholder="Nama Barang">
        <br>

        <label for="gambar">Gambar</label>
        <input type="file" class="form-control" name="gambar">
        <br>

        {{-- <label for="description">Description</label><br>
        <textarea name="description" id="description" class="form-control" placeholder="Give a description about this book"></textarea>
        <br> --}}
        <label for="categories">Categories</label><br>

        <select 
          name="categories[]" 
          multiple 
          id="categories" 
          class="form-control">
        </select>

        <br><br/>

        <label for="stock">Stock</label><br>
        <input type="number" class="form-control" id="stock" name="stock" min=0 value=0>
        <br>

        <label for="spek">Spek</label><br>
        <input type="text" class="form-control" name="spek" id="spek" placeholder="Spesifikasi">
        <br>

        <label for="publisher">Status Barang</label>  <br>
        <select name="status_barang" class="form-control">
          <option value="Milik Sendiri" selected>Milik Sendiri </option>
          <option value="Titipan">Titipan</option>
        </select>
        {{-- <input type="text" class="form-control" id="publisher" name="publisher" placeholder="Book publisher"> --}}
        <br>

        <label for="Harga">Harga</label> <br>
        <input type="number" class="form-control" name="harga" id="harga" placeholder="Barang harga">
        <br>

        <button 
          class="btn btn-primary" 
          name="save_action" 
          value="DIJUAL">DIJUAL</button>

        <button 
          class="btn btn-secondary" 
          name="save_action" 
          value="TIDAK DIJUAL">Simpan di draft</button>
      </form>
    </div>
  </div>
@endsection