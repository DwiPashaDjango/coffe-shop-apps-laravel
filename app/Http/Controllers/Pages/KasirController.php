<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kasir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KasirController extends Controller
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
        $barang = Barang::all();
        $hit = Kasir::all();
        if (request()->ajax()) {
            $data = Kasir::with('user', 'barang')->get();
            return DataTables::of($data)
            ->addColumn('qty', function($row) {
                return '<button class="btn btn-danger btn-sm kurang" data-id="'.$row->id.'"><i class="fas fa-minus"></i></button>
                        <input type="text" class="qty text-center" value="'.$row->qty.'" id="qty" readonly>
                        <button class="btn btn-success btn-sm tambah" data-id="'.$row->id.'"><i class="fas fa-plus"></i></button>';
            })
            ->addColumn('total', function($row) {
                    return number_format($row->total);
            })
            ->addColumn('action', function($row) {
                    return  '<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">Pilih</a>
                            <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                <li class="dropdown-title">-- Pilih--</li>
                                <li><a href="#" data-id="'.$row->id.'" class="dropdown-item editBarang">Edit</a></li>
                                <li><a href="#" data-id="'.$row->id.'" class="dropdown-item deleteBarang">Hapus</a></li>
                            </ul>';
            })
            ->rawColumns(['qty', 'action', 'total'])
            ->make(true);
        }
        return view('app.kasir', compact('barang', 'hit'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nm_pembeli' => 'required',
            'barang_id' => 'required',
        ], [
            'nm_pembeli.required' => 'Nama pembeli harus di isi',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $data = Kasir::create([
            'users_id' => auth()->user()->id,
            'nm_pembeli' => $request->nm_pembeli,
            'barang_id' => $request->barang_id,
            'qty' => '1',
        ]);
        $data->total = $data->barang->harga * $data->qty;
        $data->save();

        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tambah(Request $req, $id)
    {
        $data = Kasir::find($id);
        $tqty = $data->qty;
        $data->update([
            'qty' => $tqty + 1,
        ]);
        $data->total = $data->barang->harga * $data->qty;
        $data->save();
        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kurang(Request $req, $id)
    {
        $data = Kasir::find($id);
        $tqty = $data->qty;
        if ($tqty <= 1) {
            return response()->json(['errors' => 'Qty tidak bisa di kurangi lagi !']);
        } else {
            $data->update([
                'qty' => $tqty - 1,
            ]);
            $data->total = $data->barang->harga * $data->qty;
            $data->save();
        }
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
    public function destroy($id)
    {
        //
    }
}
