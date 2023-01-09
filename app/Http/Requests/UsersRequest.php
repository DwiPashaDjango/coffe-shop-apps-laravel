<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'nik' => 'required|integer',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus di isi tidak boleh kosong !',
            'email.required' => 'Email harus di isi tidak boleh kosong !',
            'email.unique' => 'Email sudah ada silahkan menggunakan email lain !',
            'email.email' => 'Kolom input email harus mengunakan @gmail.com !',
            'nik.required' => 'No Induk Kependudukan (NIK) harus di isi tidak boleh kosong !',
            'password.required' => 'Password harus di isi tidak boleh kosong !',
            'password.min' => 'Password minimal berisi 8 huruf !',
        ];
    }
}
