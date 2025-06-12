<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFullApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Bagian Application
            'nama_app' => ['required', 'string', 'max:255'],
            'fungsi_app' => ['required'],
            'url' => ['nullable', 'url:http,https'],
            'dasar_hukum' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'opd_id' => ['required'],
            'tahun_buat' => ['required', 'date_format:Y'],
            'repositori' => ['nullable', 'url:http,https'],
            'aset_takberwujud' => ['required', 'boolean'],
            'proses_bisnis' => ['nullable', 'string', 'max:255'],
            'ket_probis' => ['nullable', 'string'],
            'katpengguna_id' => ['required'],
            'katserver_id' => ['required'],
            'layananapp_id' => ['required'],
            'katapp_id' => ['required'],
            'jaringan_intra' => ['required'],
            'status' => ['required'],
            'alasan_nonaktif' => ['nullable', 'string'],
            'user_id' => ['required'],

            // Bagian Pengembangan
            'tahun_pengembangan' => ['required', 'date_format:Y'],
            'riwayat_pengembangan' => ['nullable', 'string', 'max:65535'],
            'fitur' => ['required', 'string', 'max:65535'],
            'nda' => ['nullable', 'file', 'mimes:pdf', 'max:10000'],
            'doc_perancangan' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'surat_mohon' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'kak' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'sop' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'doc_pentest' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'doc_uat' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'video_penggunaan' => ['nullable', 'url:http,https'],
            'buku_manual' => ['nullable', 'file', 'mimes:pdf', 'max:100000'],
            'katplatform_id' => ['required'],
            'katdb_id' => ['required'],
            'bahasaprogram_id' => ['required'],
            'frameworkapp_id' => ['required'],
            'capture_frontend' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:100000'],
            'capture_backend' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:100000'],
        ];
    }
}
