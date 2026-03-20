@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Contact </h3>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($Contact as $con)
                                <tr>
                                    <td>{{$con->name}}</td>
                                    <td>
                                    {{$con->email}}
                                    </td>
                                    <td>  {{$con->phone}}</td>
                                    <td>  {{$con->subject}}</td>
                                    <td>  {{$con->message}}</td>
                                    <td>{{ \Carbon\Carbon::parse($con->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td> <form action="{{ route('contact.destroy', $con->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this Contact?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                </form></td>
                                </tr>
                                @empty
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
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