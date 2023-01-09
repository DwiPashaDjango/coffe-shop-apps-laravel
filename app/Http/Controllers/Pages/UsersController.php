<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
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
            $user = User::orderBy('id', 'DESC')->get();
            return DataTables::of($user)
            ->addColumn('status', function($row) {
                if ($row->status == 'aktif') {
                   return  '<span class="badge bg-success text-white">'.$row->status.'</span>';
                } else {
                    return  '<span class="badge bg-danger text-white">'.$row->status.'</span>';
                }
            })
            ->addColumn('check', function($row) {
                return  '<input type="checkbox" value="'.$row->id.'">';
            })
            ->addColumn('action', function($row) {
                if ($row->status == 'aktif') {
                    return  '<button data-id="'.$row->id.'" class="btn btn-warning btn-sm ml-2 ban"><i class="fas fa-ban"></i></button>'.
                            '<button data-id="'.$row->id.'" class="btn btn-danger btn-sm ml-2 delete"><i class="fas fa-trash"></i></button>';
                } else {
                    return '<button data-id="'.$row->id.'" class="btn btn-success ml-2 active"><i class="fas fa-check"></i></button>';
                }
            })
            ->rawColumns(['action', 'check', 'status'])
            ->addIndexColumn() 
            ->make(true);
        }
        return view('app.data_karyawan');
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
            'name' => 'required|string',
            'email' => 'required|unique:users',
            'nik' => 'required|unique:users',
            'password' => 'required|min:8',
        ],[
            'name.required' => 'Nama harus di isi tidak boleh kosong !',
            'email.required' => 'Email harus di isi tidak boleh kosong !',
            'email.unique' => 'Email sudah ada silahkan menggunakan email lain !',
            'nik.required' => 'No Induk Kependudukan (NIK) harus di isi tidak boleh kosong !',
            'nik.unique' => 'No induk kependudukan (NIK) milik orang lain silahkan menggunakan yang lain !',
            'password.required' => 'Password harus di isi tidak boleh kosong !',
            'password.min' => 'Password minimal berisi 8 huruf !',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $data = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'status' => 'nonaktif',
            'role' => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => 200,
            'message' => 'Created Karyawan',
            'data' => $data
        ]);
       } catch (\Throwable $th) {
            throw $th;
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ban(Request $request, $id)
    {
        $data = User::find($id);
        $data->update([
            'status' => 'nonaktif',
            'password' => '',
        ]);
        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aktif(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:8'
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()]);
        }

        $data = User::find($id);
        $data->update([
            'status' => 'aktif',
            'password' => Hash::make($request->password)
        ]);
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
        $data = User::find($id);
        $data->delete();
        return response()->json([
            'success' => 200,
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
        $data = User::find($id);
        $data->update([
            'name' => $request->name,
            'nik' => $request->nik,
            'umur' => $request->umur,
            'telp' => $request->telp,
            'alamat' => $request->alamat,
        ]);
        return response()->json([
            'success' => 200,
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
    public function updatepw(Request $request)
    {
         $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        dd('Password change successfully.');
    }
}
