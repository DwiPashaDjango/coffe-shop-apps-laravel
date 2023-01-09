<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class GajiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::where('role', 'karyawan')->get();
        if (request()->ajax()) {
            $gaji = Gaji::with('user')->get();
            if ($gaji) {
                return DataTables::of($gaji)
                ->addColumn('gaji', function($row) {
                    return  number_format($row->gaji);
                })
                ->addColumn('pajak', function($row) {
                    return  number_format($row->gaji * 5/100);
                })
                ->addColumn('gb', function($row) {
                    return  number_format($row->gaji - 5/100);
                })
                ->addColumn('tgl_keluar', function($row) {
                    $car = Carbon::create($row->tgl_keluar);
                    return  $car->toFormattedDateString();
                })
                ->addColumn('action', function($row) {
                    return  '<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">Pilih</a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <li class="dropdown-title">-- Pilih--</li>
                                    <li><a href="#" data-id="'.$row->id.'" class="dropdown-item editGaji">Edit</a></li>
                                    <li><a href="#" data-id="'.$row->id.'" class="dropdown-item deleteGaji">Hapus</a></li>
                                </ul>';
                })
                ->rawColumns(['gaji', 'action', 'tgl_keluar', 'pajak', 'gb'])
                ->make(true);
            }
        }
        return view('app.data_gaji', compact('user'));
    }

    public function gajiKrywm()
    {
        if (request()->ajax()) {
            $gaji = Gaji::with('user')->where('users_id', auth()->user()->id)->get();
            if ($gaji) {
                return DataTables::of($gaji)
                ->addColumn('gaji', function($row) {
                    return  number_format($row->gaji);
                })
                ->addColumn('pajak', function($row) {
                    return  number_format($row->gaji * 5/100);
                })
                ->addColumn('gb', function($row) {
                    return  number_format($row->gaji - 5/100);
                })
                ->addColumn('tgl_keluar', function($row) {
                    $car = Carbon::create($row->tgl_keluar);
                    return  $car->toFormattedDateString();
                })
                ->addColumn('action', function($row) {
                    return  '<a href="#" data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">Pilih</a>
                                <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                    <li class="dropdown-title">-- Pilih--</li>
                                    <li><a href="#" data-id="'.$row->id.'" class="dropdown-item printGaji">Print Slip Gaji Perbulan</a></li>
                                </ul>';
                })
                ->rawColumns(['gaji', 'action', 'tgl_keluar', 'pajak', 'gb'])
                ->make(true);
            }
        }
        return view('app.data_gaji');
    }

    public function store(Request $request)
    {
        try {
            $car = Carbon::now();
            $validate = Validator::make($request->all(), [
                'users_id' => 'required|unique:gajis',
                'gaji' => 'required',
            ]);

            if ($validate->fails()) {
                return response()->json(['errors' => $validate->errors()]);
            }

            $data = Gaji::create([
                'users_id' => $request->users_id,
                'gaji' => $request->gaji,
                'tgl_keluar' => $car->addDays(30),
            ]); 

            return response()->json([
                'success' => 200,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $data = Gaji::with('user')->find($id);
        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'users_id' => 'required',
            'gaji' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $data = Gaji::find($id);
        $data->update([
            'users_id' => $request->users_id,
            'gaji' => $request->gaji,
        ]);

        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }
    
    public function printGaji($id)
    {
        $data = Gaji::find($id);
        $gj = Gaji::with('user')->where('id', '=', $id)->get();
        return view('app.print_gaji', compact('data', 'gj'));
    }

    public function destroy($id)
    {
        $data = Gaji::find($id);
        $data->delete();
        return response()->json([
            'success' => 200,
            'data' => $data,
        ]);
    }
}
