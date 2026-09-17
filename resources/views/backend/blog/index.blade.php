@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="page-title">Blogs</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i> Add Blog</a>
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
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Published At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        @if($blog->image)
                                            <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" width="60" height="45" style="object-fit:cover; border-radius:4px;">
                                        @else
                                            <span class="badge badge-secondary">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($blog->title, 50) }}</strong>
                                        <br>
                                        <small class="text-muted">/blog/{{ $blog->slug }}</small>
                                    </td>
                                    <td>{{ $blog->category ?? '—' }}</td>
                                    <td>{{ $blog->author ?? '—' }}</td>
                                    <td>
                                        <span class="badge {{ $blog->status == 'active' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($blog->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $blog->published_at ? $blog->published_at->format('d M Y') : '—' }}</td>
                                    <td>
                                        <a href="{{ route('admin.blog.edit', $blog->id) }}" class="btn btn-sm btn-primary"><i class="fe fe-edit"></i></a>
                                        <form action="{{ route('admin.blog.destroy', $blog->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fe fe-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No blogs found. <a href="{{ route('admin.blog.create') }}">Create your first blog</a>.</td>
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
@endsection
