@extends('admin.layouts.master')

@push('styles')
<link href="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(".table").DataTable({
        "order": [[ 0, "desc" ]]
    } );
</script>
@endpush

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="float-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success">
                    <i class="anticon anticon-plus"></i>
                    Create User
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>User List</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td style="width: 120px;">
                                            <div class="btn-group float-right">
                                                <a href="{{ route('admin.users.files', ['id' => $item->id]) }}" class="btn btn-sm btn-info btn-tone">
                                                    <i class="far fa-file-pdf"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', ['id' => $item->id]) }}" class="btn btn-sm btn-warning btn-tone">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </div>
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
@endsection
