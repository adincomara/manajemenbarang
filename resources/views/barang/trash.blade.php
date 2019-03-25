@extends('layouts.global')

@section('title') Trashed Barang @endsection 

@section('content') 
  <div class="row">
    <div class="col-md-12">
      @if(session('status'))
        <div class="alert alert-success">
          {{session('status')}}
        </div>
      @endif
      <div class="row">
            <div class="col-md-6">
                    <form
                      action="{{route('barang.trash')}}"
                    >
        
                    <div class="input-group">
                        <input name="keyword" type="text" value="{{Request::get('keyword')}}" class="form-control" placeholder="Cari Berdasarkan Nama">
                        <div class="input-group-append">
                          <input type="submit" value="Filter" class="btn btn-primary">
                        </div>
                    </div>
        
                    </form>
                  </div>
      <div class="col-md-6">
        <ul class="nav nav-pills card-header-pills">
          <li class="nav-item">
            <a class="nav-link {{Request::get('status') == NULL && Request::path() == 'barang' ? 'active' : ''}}" href="{{route('barang.index')}}">All</a>
          </li>
          <li class="nav-item">
              <a class="nav-link {{Request::get('status') == 'dijual' ? 'active' : '' }}" href="{{route('barang.index', ['status' => 'dijual'])}}">Dijual</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{Request::get('status') == 'tidak dijual' ? 'active' : '' }}" href="{{route('barang.index', ['status' => 'tidak dijual'])}}">Draft</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{Request::path() == 'barang/trash' ? 'active' : ''}}" href="{{route('barang.trash')}}">Trash</a>
          </li>
        </ul>
      </div>
    </div>
    
    <hr class="my-3">
      <table class="table table-bordered table-stripped">
        <thead>
          <tr>
            <th><b>Gambar</b></th>
            <th><b>Nama Barang</b></th>
            <th><b>Spesifikasi</b></th>
            <th><b>Categories</b></th>
            <th><b>Stock</b></th>
            <th><b>Harga</b></th>
            <th><b>Action</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach($barang as $brg)
            <tr>
              <td>
                @if($brg->gambar)
                  <img src="{{asset('storage/' . $brg->gambar)}}" width="96px"/>
                @endif
              </td>
              <td>{{$brg->nama}}</td>
              <td>{{$brg->spek}}</td>
              <td>
                <ul class="pl-3">
                @foreach($brg->categories as $category)
                  <li>{{$category->name}}</li>  
                @endforeach
                </ul>
              </td>
              <td>{{$brg->stock}}</td>
              <td>{{$brg->harga}}</td>
              <td>
                    <form 
                    method="POST"
                    action="{{route('barang.restore', ['id' => $brg->id])}}"
                    class="d-inline"
                  >
                  
                  {{ csrf_field() }} 
                  
                    <input type="submit" value="Restore" class="btn btn-success"/>
                  </form>

                  <form
                    method="POST" 
                    action="{{route('barang.delete-permanent', ['id' => $brg->id])}}"
                    class="d-inline"
                    onsubmit="return confirm('Hapus barang secara permanen?')"
                    >

                    {{ csrf_field() }} 
                    <input type="hidden" name="_method" value="DELETE">

                    <input type="submit" value="Delete" class="btn btn-danger btn-sm">
                    </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="10">
              {{$barang->links()}}
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection