@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Partner</h3>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-center mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse($partners as $part)
                            <tr>
                                <td>{{ $part->first_name . ' ' . $part->last_name }}</td>
                                <td>{{ $part->business_name }}</td>
                                <td>{{ $part->email }}</td>
                                <td>{{ $part->contact }}</td>
                                <td>{{ $part->address }}</td>
                                <td>{{ $part->status }}</td>
                                 <td>{{ \Carbon\Carbon::parse($part->created_at)->format('Y-m-d H:i:s') }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                       



                                        <form action="{{ route('partners.status', ['id' => $part->id]) }}" method="POST" class="me-2">
                                            @csrf
                                            @method('POST')
                                            <div class="input-group">
                                                <select class="form-select" name="status" onchange="this.form.submit()">
                                                    <option value="complete" {{ $part->status == 'complete' ? 'selected' : '' }}>Complete</option>
                                                    <option value="inprogress" {{ $part->status == 'inprogress' ? 'selected' : '' }}>Inprogress</option>
                                                    <option value="pending" {{ $part->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                </select>
                                            </div>
                                        </form>

                                        
                                       
                                        <form class="ml-3" action="{{ route('partner.destroy', $part->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Partner?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                        </form>
                                    </div>
                                </td>


                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">No partners found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(Session::has('error'))
        iziToast.error({
            title: 'error',
            message: '{{ Session::get("error") }}',
            backgroundColor: '#f70400', // Set the background color to black
            titleColor: 'white', // Set the title color to white for better visibility
            messageColor: 'white', // Set the message color to white for better visibility
            icon: 'mdi mdi-close', // MDI information icon
            iconColor: 'white',
        });
        @endif

        @if(Session::has('success'))
        iziToast.success({
            title: 'Success',
            message: '{{ Session::get("success") }}',
            backgroundColor: '#40a7a3', // Set the background color to black
            titleColor: 'white', // Set the title color to white for better visibility
            messageColor: 'white', // Set the message color to white for better visibility
            icon: 'mdi mdi-check', // MDI information icon
            iconColor: 'white',
        });
        @endif
    });
</script>
@endsection