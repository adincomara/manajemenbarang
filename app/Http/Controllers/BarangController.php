<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $keyword = $request->get('keyword') ? $request->get('keyword') : '';

        $categ = \App\Category::where('name', $keyword)->get();

        if(!empty($categ[0])){
            $barang = \App\Barang::with('categories')->join('barang_category', 'barang.id', '=', 'barang_category.barang_id')->join('categories', 'barang_category.category_id', '=', 'categories.id')->where('categories.id', '=', $categ[0]->id)->paginate(10);

            return view('barang.index', ['barang' => $barang]);
        }

        
    
        if($status){
            $barang = \App\Barang::with('categories')->where('nama', "LIKE", "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        } else {
            $barang = \App\Barang::with('categories')->where("nama", "LIKE", "%$keyword%")->paginate(10);
        }
    
        return view('barang.index', ['barang' => $barang]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $new_barang = new \App\Barang;
        $new_barang->nama = $request->get('nama');
        // $new_barang->description = $request->get('description');
        $new_barang->spek = $request->get('spek');
        $new_barang->status_barang = $request->get('status_barang');
        $new_barang->harga = $request->get('harga');
        $new_barang->stock = $request->get('stock');

        $new_barang->status = $request->get('save_action');

        $gambar = $request->file('gambar');

        if($gambar){
            $gambar_path = $gambar->store('barang-gambar', 'public');

            $new_barang->gambar = $gambar_path;
        }

        $new_barang->slug = str_slug($request->get('nama'));

        $new_barang->created_by = \Auth::user()->id;

        $new_barang->save();

        $new_barang->categories()->attach($request->get('categories'));

        if($request->get('save_action') == 'DIJUAL'){
            return redirect()
                ->route('barang.create')
                ->with('status', 'Barang berhasil disimpan dan dijual');
        } else {
            return redirect()
                ->route('barang.create')
                ->with('status', 'Barang tersimpan di Draft');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $barang = \App\Barang::findOrFail($id);

        return view('barang.edit', ['barang' => $barang]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $barang = \App\Barang::findOrFail($id);

        $barang->nama = $request->get('nama');
        $barang->slug = $request->get('slug');
        // $barang->description = $request->get('description');
        $barang->spek = $request->get('spek');
        $barang->status_barang = $request->get('status_barang');
        $barang->stock = $request->get('stock');
        $barang->harga = $request->get('harga');

        $new_gambar = $request->file('gambar');

        if($new_gambar){
            if($barang->gambar && file_exists(storage_path('app/public/' . $barang->gambar))){
                \Storage::delete('public/'. $barang->gambar);
            }

            $new_gambar_path = $new_gambar->store('barang-gambar', 'public');

            $barang->gambar = $new_gambar_path;
        }

        $barang->updated_by = \Auth::user()->id;

        $barang->status = $request->get('status');

        $barang->save();

        $barang->categories()->sync($request->get('categories'));

        return redirect()->route('barang.edit', ['id'=>$barang->id])->with('status', 'Barang berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $barang = \App\Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('status', 'Barang moved to trash');
    }
    public function trash(Request $request){
        $barang = \App\Barang::onlyTrashed()->paginate(10);
        // $status = $request->get('status');

        // $keyword = $request->get('keyword') ? $request->get('keyword') : '';
    
        // if($status){
        //     $barang = \App\Barang::with('categories')->where('nama', "LIKE", "%$keyword%")->where('status', strtoupper($status))->paginate(10);
        // } else {
        //     $barang = \App\Barang::with('categories')->where("nama", "LIKE", "%$keyword%")->paginate(10);
        // }
      
        return view('barang.trash', ['barang' => $barang]);
      }
    public function restore($id){
        $barang = \App\Barang::withTrashed()->findOrFail($id);
        
        if($barang->trashed()){
            $barang->restore();
            return redirect()->route('barang.trash')->with('status', 'Barang berhasil di restore');
        } else {
            return redirect()->route('barang.trash')->with('status', 'Barang tidak ada di Trash');
        }
    }
    public function deletePermanent($id){
        $barang = \App\Barang::withTrashed()->findOrFail($id);
      
        if(!$barang->trashed()){
          return redirect()->route('barang.trash')->with('status', 'Barang tidak ada di Trash!')->with('status_type', 'alert');
        } else {
          $barang->categories()->detach();
          $barang->forceDelete();
      
          return redirect()->route('barang.trash')->with('status', 'Barang telah di hapus permanen!');
        }
      }
}
