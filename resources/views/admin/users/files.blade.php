@extends('admin.layouts.master')

@push('styles')
<link href="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

{{-- <script>
    $(".table").DataTable({
        "order": [[ 0, "desc" ]]
    } );
</script> --}}

<script>
    $(".input_check").click(function(){
        var all = true;
        var items = $(".input_check");
        $.each(items, function(){
            if($(this).prop('checked') === false)
                all = false;
        });

        if(all === true)
            $("#all_check").prop("checked", true);
        else
            $("#all_check").prop("checked", false);

        var one = false;
        $.each(items, function(){
            if($(this).prop('checked') === true)
                one = true;
        });

        if(one === true)
        {
            $("#send_btn").prop('disabled', false);
        }else{
            $("#send_btn").prop('disabled', true);
        }
    })

    $("#all_check").click(function(){
        if($(this).prop('checked'))
        {
            $(".input_check").prop('checked', true);
            $("#send_btn").prop('disabled', false);
        }
        else
        {
            $(".input_check").prop('checked', false);
            $("#send_btn").prop('disabled', true);
        }
    })

    function checkAll()
    {
        var all_check_box = $(".input_check");
        console.log(all_check_box);
    }
</script>

@endpush

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Upload Files</h4>
                    <div class="row">
                        <form action="{{ route('admin.users.files.upload', ['id' => $user->id]) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="file ">Select File *</label>
                                    <input type="file" accept="application/pdf" class="form-control" id="file" name="file" placeholder="Select File" required>
                                    @error('file')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-success">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.file.multiple', ['customer' => $user->id]) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <h4>File List of {{ $user->email }}</h4>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="float-right">
                                    <button type="submit" class="btn btn-sm btn-success" id="send_btn" disabled>
                                        <i class="fas fa-envelope"></i>
                                        SEND ALL FILE
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <input type="checkbox" id="all_check">
                                                </th>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Upload Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($files as $item)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="ids[]" id="" class="input_check" value="{{ $item->id }}">
                                                    </td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->file_name }}</td>
                                                    <td>{{ date('d, M Y', strtotime($item->created_at)) }}</td>
                                                    <td style="width: 100px">
                                                        <div class="btn-group float-right">
                                                            <a href="{{ route('admin.file.send', ['id' => $item->id, 'customer' => $user->id]) }}" class="btn btn-sm btn-success btn-tone">
                                                                <i class="fas fa-paper-plane"></i>
                                                            </a>
                                                            <a href="{{ route('admin.file', ['id' => $item->id]) }}" target="_blank" class="btn btn-sm btn-info btn-tone">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="#" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger btn-tone">
                                                                <i class="fas fa-trash-alt"></i>
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
            </form>
        </div>
    </div>
@endsection
