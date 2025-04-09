<?php

namespace App\Http\Controllers;

use App\Models\Monevapp;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMonevRequest;
use App\Http\Requests\UpdateMonevRequest;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MonevappController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Application $application)
    {
        $monevapps = Monevapp::where('application_id', $application->id)->get();

        return view('monevapp.monevapp-index', compact('application', 'monevapps'), [
            'title' => 'Monev Aplikasi'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Application $application)
    {
        return view('monevapp.monevapp-create', compact('application'), [
            'title' => 'Monev Aplikasi'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonevRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            if ($request->hasFile('bukti_monev')) {
                $bukti_monevPath = $request->file('bukti_monev')->store('aplikasi/bukti-monevs', 'public');
                $validated['bukti_monev'] = $bukti_monevPath;
            }

            $newMonevapp = Monevapp::create($validated);
        });

        return redirect()->route('admin.application.index')->with('success', 'Data telah tersimpan dengan sukses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Monevapp $monevapp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application, Monevapp $monevapp)
    {
        return view('monevapp.monevapp-edit', compact('application', 'monevapp'), [
            'title' => 'Monev Aplikasi'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Application $application, UpdateMonevRequest $request, Monevapp $monevapp)
    {
        DB::transaction(function () use ($request, $monevapp) {
            $validated = $request->validated();

            if ($request->hasFile('bukti_monev')) {
                Storage::disk('public')->delete($monevapp->bukti_monev);

                $bukti_monevPath = $request->file('bukti_monev')->store('aplikasi/bukti-monevs', 'public');
                $validated['bukti_monev'] = $bukti_monevPath;
            }

            $monevapp->update($validated);
        });

        return redirect()->route('admin.application.index')->with('success', 'Perubahan data telah berhasil dilakukan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application, Monevapp $monevapp)
    {
        DB::transaction(function () use ($monevapp) {

            // Hapus file PDF jika ada
            // if ($monevapp->bukti_monev && Storage::exists($monevapp->bukti_monev)) {
            //     Storage::delete($monevapp->bukti_monev);
            // }

            $monevapp->delete();
        });

        return redirect()->route('admin.application.index')->with('success', 'Penghapusan data sukses dilakukan.');
    }
}
