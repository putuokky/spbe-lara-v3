@extends('layouts.app')

@section('title', $title)

@push('style')
    <!-- Data Tables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.min.css" />
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ $title }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">{{ $title }}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h4>{{ __($title) }}</h4>
                        </div> --}}
                        <div class="card-body">
                            <a href="{{ route('admin.monevapp.create', $application->id) }}" class="btn btn-primary mb-3"><i
                                    class="fas fa-plus"></i> Add</a>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" id="myTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Action</th>
                                            <th>Aplikasi</th>
                                            <th>Tanggal Monev</th>
                                            <th>Bukti Monev</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monevapps as $monevapp)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    {{-- <a href="{{ route('admin.monevapp.show', ['application' => $application->id, 'monevapp' => $monevapp->id]) }}"
                                                        class="btn btn-dark btn-sm" title="Detail"><i
                                                            class="fas fa-info-circle"></i></a> --}}
                                                    <button type="button" class="btn btn-dark btn-sm monevappClass"
                                                        data-toggle="modal" data-target="#monevappModal"
                                                        data-id="{{ $monevapp->id }}" title="Detail">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>
                                                    <a href="{{ route('admin.monevapp.edit', ['application' => $application->id, 'monevapp' => $monevapp->id]) }}"
                                                        class="btn btn-light btn-sm" title="Edit"><i
                                                            class="fas fa-edit"></i></a>
                                                    <form
                                                        action="{{ route('admin.monevapp.destroy', ['application' => $application->id, 'monevapp' => $monevapp->id]) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-light btn-sm show_confirm"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                                <td>{{ $monevapp->app->nama_app }}</td>
                                                <td>{{ $monevapp->tgl_monev->locale('id')->translatedFormat('d F Y') }}</td>
                                                <td>
                                                    @if ($monevapp->bukti_monev)
                                                        <a href="{{ asset(Storage::url($monevapp->bukti_monev)) }}"
                                                            target="_blank">View Dokumen Bukti Monev</a>
                                                    @else
                                                        {{ '-' }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('monevapp/monevapp-modal')
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script>
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: 'Apakah Anda yakin ingin menghapus data ini?',
                    text: "Jika Anda menghapus data ini, akan hilang selamanya.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>

    <!-- Data Tables -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $("#myTable").dataTable({
            "searching": true
        });
    </script>

    <script>
        $(document).on('click', '.monevappClass', function() {
            var id = $(this).data('id');

            $.ajax({
                url: "{{ URL::to('/masternilai/indikator/json/data') }}",
                type: 'post',
                data: {
                    id: id,
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(response) {
                    $('#ket_indikator').html(response.ket_indikator);
                }
            });
        });
    </script>
@endpush
