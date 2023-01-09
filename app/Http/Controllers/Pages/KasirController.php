<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Kasir;
use Illuminate\Http\Request;
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
        if (request()->ajax()) {
            $data = Kasir::with('user', 'barang')->get();
            return DataTables::of($data)
            ->addColumn('qty', function($row) {
                    if ($row->qty > 1) {
                        return '<button class="btn btn-danger btn-sm kurang"><i class="fas fa-minus"></i></button>
                                <input type="text" class="qty text-center" value="'.$row->qty.'" id="qty" readonly>
                                <button class="btn btn-success btn-sm tambah"><i class="fas fa-plus"></i></button>';
                    } else {
                        return '<input type="text" class="qty text-center" value="'.$row->qty.'" id="qty" readonly>
                                <button class="btn btn-success btn-sm tambah"><i class="fas fa-plus"></i></button>';
                    }
            })
            ->addColumn('total', function($row) {
                    return number_format($row->qty * $row->barang->harga);
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
        return view('app.kasir');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kurang(Request $req, $id)
    {
        //
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
