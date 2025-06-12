<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\StoreFullApplicationRequest; //new class for multiple insert table requests
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Bahasaprogram;
use App\Models\Frameworkapp;
use App\Models\Interop;
use App\Models\Katapp;
use App\Models\Katdb;
use App\Models\Katpengguna;
use App\Models\Katplatform;
use App\Models\Katserver;
use App\Models\Layananapp;
use App\Models\Monevapp;
use App\Models\Opd;
use App\Models\Pengembangan;
use App\Models\Sdmteknic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = Application::whereIn('katapp_id', [1, 2])->get();

        return view('aplikasi.aplikasi-index', compact('applications'), [
            'title' => 'Data Aplikasi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $opds = Opd::all();
        $katpenggunas = Katpengguna::all();
        $katservers = Katserver::all();
        $layananapps = Layananapp::all();
        $katapps = Katapp::whereIn('id', [1, 2])->get();

        // For Pengembangan
        $katplatforms = Katplatform::all();
        $katdbs = Katdb::all();
        $bhsprograms = Bahasaprogram::all();
        $frameworkapps = Frameworkapp::all();
        // $noRegis = Str::upper(Str::random(8));

        return view('aplikasi.aplikasi-create', compact('opds', 'katpenggunas', 'katservers', 'layananapps', 'katapps', 'katplatforms', 'katdbs', 'bhsprograms', 'frameworkapps'), [
            'title' => 'Data Aplikasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFullApplicationRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            // Generate no_regis_app
            $validated['no_regis_app'] = Str::upper(Str::random(12));

            // Handle file upload Application
            if ($request->hasFile('dasar_hukum')) {
                $validated['dasar_hukum'] = $request->file('dasar_hukum')->store('aplikasi/dasar-hukums', 'public');
            }

            // Simpan data Application
            $application = Application::create([
                'no_regis_app' => $validated['no_regis_app'],
                'nama_app' => $validated['nama_app'],
                'fungsi_app' => $validated['fungsi_app'],
                'url' => $validated['url'] ?? null,
                'dasar_hukum' => $validated['dasar_hukum'] ?? null,
                'opd_id' => $validated['opd_id'],
                'tahun_buat' => $validated['tahun_buat'],
                'repositori' => $validated['repositori'] ?? null,
                'aset_takberwujud' => $validated['aset_takberwujud'],
                'proses_bisnis' => $validated['proses_bisnis'] ?? null,
                'ket_probis' => $validated['ket_probis'] ?? null,
                'katpengguna_id' => $validated['katpengguna_id'],
                'katserver_id' => $validated['katserver_id'],
                'layananapp_id' => $validated['layananapp_id'],
                'katapp_id' => $validated['katapp_id'],
                'jaringan_intra' => $validated['jaringan_intra'],
                'status' => $validated['status'],
                'alasan_nonaktif' => $validated['alasan_nonaktif'] ?? null,
                'user_id' => $validated['user_id'],
            ]);

            // Mapping untuk file Pengembangan
            $fileFields = [
                'nda' => 'pengembangan/ndas',
                'doc_perancangan' => 'pengembangan/perancangans',
                'surat_mohon' => 'pengembangan/surat-mohons',
                'kak' => 'pengembangan/kaks',
                'sop' => 'pengembangan/sops',
                'doc_pentest' => 'pengembangan/pentests',
                'doc_uat' => 'pengembangan/uats',
                'buku_manual' => 'pengembangan/buku-manuals',
                'capture_frontend' => 'pengembangan/capture-frontends',
                'capture_backend' => 'pengembangan/capture-backends',
            ];

            foreach ($fileFields as $field => $path) {
                if ($request->hasFile($field)) {
                    $validated[$field] = $request->file($field)->store($path, 'public');
                }
            }

            // Simpan data Pengembangan
            Pengembangan::create([
                'application_id' => $application->id,
                'tahun_pengembangan' => $validated['tahun_pengembangan'],
                'riwayat_pengembangan' => $validated['riwayat_pengembangan'] ?? null,
                'fitur' => $validated['fitur'],
                'nda' => $validated['nda'] ?? null,
                'doc_perancangan' => $validated['doc_perancangan'] ?? null,
                'surat_mohon' => $validated['surat_mohon'] ?? null,
                'kak' => $validated['kak'] ?? null,
                'sop' => $validated['sop'] ?? null,
                'doc_pentest' => $validated['doc_pentest'] ?? null,
                'doc_uat' => $validated['doc_uat'] ?? null,
                'video_penggunaan' => $validated['video_penggunaan'] ?? null,
                'buku_manual' => $validated['buku_manual'] ?? null,
                'katplatform_id' => $validated['katplatform_id'],
                'katdb_id' => $validated['katdb_id'],
                'bahasaprogram_id' => $validated['bahasaprogram_id'],
                'frameworkapp_id' => $validated['frameworkapp_id'],
                'capture_frontend' => $validated['capture_frontend'] ?? null,
                'capture_backend' => $validated['capture_backend'] ?? null,
                'user_id' => $validated['user_id'],
            ]);
        });

        return redirect()->route('admin.application.index')->with('success', 'Data aplikasi dan pengembangan berhasil disimpan!');
    }
    // public function store(StoreApplicationRequest $request) 
    // {
    //     DB::transaction(function () use ($request) {
    //         $validated = $request->validated();

    //         $validated['no_regis_app'] = Str::upper(Str::random(12));

    //         if ($request->hasFile('dasar_hukum')) {
    //             $dasar_hukumPath = $request->file('dasar_hukum')->store('aplikasi/dasar-hukums', 'public');
    //             $validated['dasar_hukum'] = $dasar_hukumPath;
    //         }

    //         $newApplication = Application::create($validated);
    //     });

    //     return redirect()->route('admin.application.index')->with('success', 'Data telah tersimpan dengan sukses!');
    // }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        $monevapps = Monevapp::where('application_id', $application->id)->orderBy('tgl_monev', 'desc')->get();
        $sdmteknics = Sdmteknic::where('application_id', $application->id)->get();
        $interops = Interop::where('application_id', $application->id)->get();
        $pengembangans = Pengembangan::where('application_id', $application->id)->orderBy('tahun_pengembangan', 'desc')->get();

        return view('aplikasi.aplikasi-detail', compact('application', 'monevapps', 'sdmteknics', 'interops', 'pengembangans'), [
            'title' => 'Data Aplikasi'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        $opds = Opd::all();
        $katpenggunas = Katpengguna::all();
        $katservers = Katserver::all();
        $layananapps = Layananapp::all();
        $katapps = Katapp::whereIn('id', [1, 2])->get();

        return view('aplikasi.aplikasi-edit', compact('application', 'opds', 'katpenggunas', 'katservers', 'layananapps', 'katapps'), [
            'title' => 'Data Aplikasi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        DB::transaction(function () use ($request, $application) {
            $validated = $request->validated();

            if (empty($application->no_regis_app)) {
                $validated['no_regis_app'] = Str::upper(Str::random(12));
            }

            if ($request->hasFile('dasar_hukum')) {

                if (!empty($application->dasar_hukum)) {
                    Storage::disk('public')->delete($application->dasar_hukum);
                }

                $dasar_hukumPath = $request->file('dasar_hukum')->store('aplikasi/dasar-hukums', 'public');
                $validated['dasar_hukum'] = $dasar_hukumPath;
            }

            if (isset($validated['status']) && $validated['status'] === '1') {
                $validated['alasan_nonaktif'] = null;
            }

            $application->update($validated);
        });

        return redirect()->route('admin.application.index')->with('success', 'Perubahan data telah berhasil dilakukan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        // dd($application);
        DB::transaction(function () use ($application) {
            $application->delete();
        });

        return redirect()->route('admin.application.index')->with('success', 'Penghapusan data sukses dilakukan.');
    }
}
