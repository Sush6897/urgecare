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
                <form action="{{ route('contact.create') }}" method="GET">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fe fe-search"></i> Search </button>
                                    <a href="{{ route('contact.create') }}" class="btn btn-danger btn-block">Reset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
@endsection