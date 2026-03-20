@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title"> Enquiry </h3>

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
                                    <th>Call ID</th>
                                    <th>Patient Name</th>
                                    <th>Hospital Name</th>
                                    <th>Patient Contact</th>
                                    <th>Hospital Contact</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>


                                @forelse($enquiry as $enq)
                                <tr>
                                    <td>{{$enq->sid}}</td>
                                    <td>{{$enq->patient_name}}</td>
                                    <td>{{$enq->hospital->hospital_name}}</td>
                                    <td>{{$enq->from}}</td>
                                    <td>{{$enq->to}}</td>
                                    <td>{{$enq->status}}</td>
                                    <td>{{ \Carbon\Carbon::parse($enq->created_at)->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                         
                                            <form action="{{ route('enquiry.status', ['id' => $enq->id]) }}" method="POST" class="me-2">
                                                @csrf
                                                @method('POST')
                                                <div class="input-group">
                                                    <select class="form-select" name="status" onchange="this.form.submit()">
                                                        <option value="success" {{ $enq->status == 'success' ? 'selected' : '' }}>Success</option>
                                                        <option value="notconnected" {{ $enq->status == 'notconnected' ? 'selected' : '' }}>Notconnected</option>
                                                        <option value="pending" {{ $enq->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    </select>
                                                </div>
                                            </form>

                                            <form class="ml-3" action="{{ route('enquiry.destroy', $enq->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Enquiry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No enquiries found.</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('/backend/assets/js/jquery-3.2.1.min.js')}}"></script>
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