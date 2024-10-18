<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PetugasRequest extends FormRequest
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
            'id_satker'=>'required',
            'nama_petugas'=>'required',
            'email_bps'=>'required',
            'email_google'=>'required',
            'jabatan'=>'required',
            'tampil'=>'required',
            'nip_lama'=>'required',
            'no_hp' => 'required|regex:/^08[0-9]{8,10}$/',
            'status'=>'required',
            'foto'=>'nullable|image|file|mimes:png,jpg,jpeg,webp|max:3024',
            'hit'=>'nullable',
            'jenis_kelamin'=>'required',
            'nama_panggilan'=>'required',
            'keahlian'=>'required',
            'tanggal_update'=>'nullable'
        ];
    }
}
