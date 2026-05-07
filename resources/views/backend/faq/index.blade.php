@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">FAQs</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.faq.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Add FAQ</a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="datatable table table-hover table-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($faqs as $faq)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $faq->question }}</td>
                                    <td>{{ $faq->order }}</td>
                                    <td>
                                        <span class="badge {{ $faq->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($faq->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn btn-sm btn-primary"><i class="fe fe-pencil"></i></a>
                                        <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                        </form>
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
@endsection
