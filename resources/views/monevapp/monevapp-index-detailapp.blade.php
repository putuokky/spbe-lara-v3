<div class="table-responsive">
    {{-- <a href="{{ route('admin.monevapp.create', $application->id) }}" class="btn btn-primary mb-3"><i
            class="fas fa-plus"></i> Add</a> --}}
    <table class="table table-bordered table-hover" id="myTableMonev">
        <thead>
            <tr>
                {{-- <th>Action</th> --}}
                <th>Tanggal Monev</th>
                <th>Bukti Monev</th>
                <th>Keterangan Monev</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($monevapps as $monevapp)
                <tr>
                    {{-- <td>
                        <a href="{{ route('admin.monevapp.edit', ['application' => $application->id, 'monevapp' => $monevapp->id]) }}"
                            class="btn btn-light btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                        <form
                            action="{{ route('admin.monevapp.destroy', ['application' => $application->id, 'monevapp' => $monevapp->id]) }}"
                            method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm show_confirm" title="Delete"><i
                                    class="fas fa-trash"></i></button>
                        </form>
                    </td> --}}
                    <td>{{ $monevapp->tgl_monev->locale('id')->translatedFormat('d F Y') }}
                    </td>
                    <td>
                        @if ($monevapp->bukti_monev)
                            <a href="{{ asset(Storage::url($monevapp->bukti_monev)) }}" target="_blank">View Dokumen
                                Bukti Monev</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{!! $monevapp->ket_monev ? $monevapp->ket_monev : '<span class="text-muted">-</span>' !!}</td>
                    <td><span class="btn btn-sm btn-outline-dark">
                            {{ $monevapp->updated_at->translatedFormat('d F Y') }}
                            oleh
                            {{ $monevapp->user->name }}</span></td>
                </tr>
            @empty
                {{-- <tr>
                    <td colspan="5">No data available in table</td>
                </tr> --}}
            @endforelse
        </tbody>
    </table>
</div>
