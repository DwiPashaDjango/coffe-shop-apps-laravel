<?php

namespace App\Http\Controllers\Pages;

use App\Exports\BarangExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bar = Barang::get();
        if (request()->ajax()) {
            $data = Barang::with('kategori')->latest()->get();
            if ($data) {
                return DataTables::of($data)
                ->addColumn('kategori', function($row) {
                    if ($row->kategori->nm_kategori == 'Makanan') {
                    return  '<span class="badge bg-primary text-white">'.$row->kategori->nm_kategori.'</span>';
                    } else {
                        return  '<span class="badge bg-warning text-white">'.$row->kategori->nm_kategori.'</span>';
                    }
                })
                ->addColumn('harga', function($row) {
                    return  number_format($row->harga);
                })
                ->addColumn('kode', function($row) {
                    return  '<a href="#"><span class="text-large">'.$row->kode.'</span></a>';
                })
                ->addColumn('action', function($row) {
                    if (auth()->user()->role == 'admin') {
                        return  '<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">Pilih</a>
                                    <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <li class="dropdown-title">-- Pilih--</li>
                                        <li><a href="#" data-id="'.$row->id.'" class="dropdown-item editBarang">Edit</a></li>
                                        <li><a href="#" data-id="'.$row->id.'" class="dropdown-item deleteBarang">Hapus</a></li>
                                    </ul>';
                    } else {
                        return '<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">Pilih</a>';
                    }
                })
                ->rawColumns(['kategori', 'action','harga', 'kode'])
                ->make(true);
            }
        }
        return view('app.data_barang', compact('bar'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'nm_barang' => 'required',
                'kategori_id' => 'required',
                'jumlah' => 'required',
                'harga' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()]);
            }

            $data = Barang::create([
                'nm_barang' => $request->nm_barang,
                'kategori_id' => $request->kategori_id,
                'jumlah' => $request->jumlah,
                'harga' => $request->harga,
            ]);

            return response()->json([
                'success' => 200,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw $th;
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
        $data = Barang::with('kategori')->find($id);
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
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
        $this->validate($request, [
            'nm_barang' => 'required',
            'kategori_id' => 'required',
            'jumlah' => 'required',
            'harga' => 'required',
        ], [
            'kategori_id.required' => 'Kategori kolom tidak boleh kosong !'
        ]);

        $input = $request->all();
        $data = Barang::find($id);
        $data->update($input);
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Barang::find($id);
        $data->delete();
        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kategoriJson(Request $request)
    {
        $search = $request->search;

        if($search == ''){
            $kategori = Kategori::orderby('nm_kategori','asc')->select('id','nm_kategori')->limit(5)->get();
        }else{
            $kategori = Kategori::orderby('nm_kategori','asc')->select('id','nm_kategori')->where('nm_kategori', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($kategori as $kt){
            $response[] = array(
                "id"=>$kt->id,
                "text"=>$kt->nm_kategori
            );
        }
        return response()->json($response); 
    }

    public function export()
    {
        return Excel::download(new BarangExport, 'data-barang.xlsx');
    }

    public function print()
    {
        $data = Barang::with('kategori')->get();
        return view('app.print_barang', compact('data'));
    }
}
