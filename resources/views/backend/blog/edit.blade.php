@extends('layout.backend.app')
@section('content')
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm-6">
                <h3 class="page-title">Edit Blog</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary"><i class="fe fe-arrow-left"></i> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="blogTitle" class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $blog->title) }}" placeholder="Enter blog title" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Slug</label>
                                    <input type="text" name="slug" id="blogSlug" class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug', $blog->slug) }}" placeholder="auto-generated-from-title" data-edited="true">
                                    <small class="text-muted">Leave blank to auto-generate from title.</small>
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Excerpt</label>
                                    <textarea name="excerpt" class="form-control @error('excerpt') is-invalid @enderror"
                                        rows="2" placeholder="Short summary (max 500 characters)...">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                    @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Content <span class="text-danger">*</span></label>
                                    <textarea name="content" id="blogContent" class="form-control @error('content') is-invalid @enderror"
                                        rows="12" placeholder="Write your blog content here..." required>{{ old('content', $blog->content) }}</textarea>
                                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="mb-3">Publish Settings</h6>

                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control">
                                                <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $blog->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Published At</label>
                                            <input type="datetime-local" name="published_at" class="form-control"
                                                value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Author</label>
                                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                                                value="{{ old('author', $blog->author) }}" placeholder="Author name">
                                            @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Category</label>
                                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                                                value="{{ old('category', $blog->category) }}" placeholder="e.g. Health, Tips">
                                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label>Featured Image</label>

                                            @if($blog->image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="Current Image"
                                                        class="img-fluid rounded" style="max-height:150px;" id="currentImg">
                                                    <small class="d-block text-muted mt-1">Current image. Upload a new one to replace it.</small>
                                                </div>
                                            @endif

                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror"
                                                    id="blogImage" accept="image/*">
                                                <label class="custom-file-label" for="blogImage">Choose new image...</label>
                                            </div>
                                            @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                            <div id="imagePreview" class="mt-2" style="display:none;">
                                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height:150px;">
                                            </div>
                                        </div>

                                        <div class="text-right mt-3">
                                            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary mr-1">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-generate slug from title (only if user hasn't manually edited it)
    document.getElementById('blogTitle').addEventListener('input', function () {
        const slugField = document.getElementById('blogSlug');
        if (!slugField.dataset.edited || slugField.dataset.edited === 'false') {
            slugField.value = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    });

    // Image preview
    document.getElementById('blogImage').addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                const current = document.getElementById('currentImg');
                if (current) current.style.display = 'none';
            };
            reader.readAsDataURL(file);
            document.querySelector('.custom-file-label').textContent = file.name;
        }
    });
</script>
@endsection
