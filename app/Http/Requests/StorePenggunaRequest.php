<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'nama_pengguna'=>'required',
            'email_google'=>'required',
            'family_name'=>'required',
            'given_name'=>'required',
            'foto'=>'nullable|image|file|mimes:png,jpg,jpeg,webp|max:3024',
            'pekerjaan'=>'nullable',
            'jenis_kelamin'=>'nullable',
            'id_prov'=>'nullable',
            'id_kab'=>'nullable',
            'tanggal_lahir'=>'nullable',
            'nmr_telp'=>'required|regex:/^08[0-9]{8,10}$/',
            'pendidikan'=>'nullable',
            'create_at'=>'nullable',
            'update_at'=>'nullable'
        ];
    }
}
