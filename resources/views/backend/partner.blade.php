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
                <form action="{{ route('partners.create') }}" method="GET">
                    <div class="row filter-row">
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Business Name</label>
                                <input type="text" name="business_name" class="form-control" value="{{ request('business_name') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ request('email') }}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fe fe-search"></i> Search </button>
                                    <a href="{{ route('partners.create') }}" class="btn btn-danger btn-block">Reset</a>
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
@endsection