<?php

namespace App\Http\Controllers;

use App\Models\Subdomain;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubdomainRequest;
use App\Http\Requests\UpdateSubdomainRequest;
use App\Models\Opd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubdomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subdomains = Subdomain::all();

        return view('subdomain.subdomain-index', compact('subdomains'), [
            'title' => 'Data Portal Subdomain'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $response = Http::get('https://splp.denpasarkota.go.id/index.php/dev/master/opd');
        // $opds = $response->json(['entry']);

        $opds = Opd::all();

        return view('subdomain.subdomain-create', compact('opds'), [
            'title' => 'Data Portal Subdomain'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubdomainRequest $request)
    {
        DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $newSubdomain = Subdomain::create($validated);
        });

        flash()->success('Data telah tersimpan dengan sukses!');
        return redirect()->route('system.subdomain.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subdomain $subdomain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subdomain $subdomain)
    {
        // $response = Http::get('https://splp.denpasarkota.go.id/index.php/dev/master/opd');
        // $opds = $response->json(['entry']);

        return view('subdomain.subdomain-edit', compact('subdomain', 'opds'), [
            'title' => 'Data Portal Subdomain'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubdomainRequest $request, Subdomain $subdomain)
    {
        DB::transaction(function () use ($request, $subdomain) {
            $validated = $request->validated();

            $subdomain->update($validated);
        });

        flash()->success('Perubahan data telah berhasil dilakukan.');
        return redirect()->route('system.subdomain.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subdomain $subdomain)
    {
        DB::transaction(function () use ($subdomain) {
            $subdomain->delete();
        });

        flash()->success('Penghapusan data sukses dilakukan.');
        return redirect()->route('system.subdomain.index');
    }
}
