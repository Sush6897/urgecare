@extends('layout.frontend.app')
@section('content')

<section class="page-title py-4" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($blog->title, 50) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<section class="blog-detail py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <article class="card border-0 shadow-sm" style="border-radius:12px; overflow:hidden;">

                    <!-- Featured Image -->
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                            class="img-fluid w-100" style="max-height:420px; object-fit:cover;">
                    @endif

                    <div class="card-body p-4 p-md-5">

                        <!-- Meta -->
                        <div class="d-flex flex-wrap align-items-center mb-3" style="gap:12px;">
                            @if($blog->category)
                                <span class="badge badge-pill" style="background:#e8f4fd; color:#2b6cb0; font-size:0.8rem; padding:6px 14px;">
                                    <i class="fas fa-tag mr-1"></i>{{ $blog->category }}
                                </span>
                            @endif
                            <small class="text-muted">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $blog->published_at ? $blog->published_at->format('d F Y') : $blog->created_at->format('d F Y') }}
                            </small>
                            @if($blog->author)
                                <small class="text-muted">
                                    <i class="far fa-user mr-1"></i>{{ $blog->author }}
                                </small>
                            @endif
                        </div>

                        <!-- Title -->
                        <h1 class="mb-4" style="font-weight:800; color:#2d3748; font-size:1.8rem; line-height:1.3;">
                            {{ $blog->title }}
                        </h1>

                        <!-- Excerpt -->
                        @if($blog->excerpt)
                            <p class="lead text-muted mb-4" style="border-left:4px solid #667eea; padding-left:16px; font-style:italic;">
                                {{ $blog->excerpt }}
                            </p>
                        @endif

                        <!-- Content -->
                        <div class="blog-content" style="font-size:1.05rem; line-height:1.9; color:#4a5568;">
                            {!! nl2br(e($blog->content)) !!}
                        </div>

                        <!-- Share / Back -->
                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4" style="border-top:1px solid #eee;">
                            <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary" style="border-radius:20px;">
                                <i class="fas fa-arrow-left mr-1"></i> All Blogs
                            </a>
                            <div class="d-flex align-items-center" style="gap:10px;">
                                <span class="text-muted small mr-2">Share:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank" class="btn btn-sm btn-primary" style="border-radius:50%; width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($blog->title) }}"
                                    target="_blank" class="btn btn-sm" style="background:#1da1f2; color:white; border-radius:50%; width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . request()->url()) }}"
                                    target="_blank" class="btn btn-sm" style="background:#25d366; color:white; border-radius:50%; width:36px; height:36px; padding:0; display:flex; align-items:center; justify-content:center;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mt-4 mt-lg-0">

                <!-- Recent Blogs -->
                @php
                    $recentBlogs = \App\Models\Blog::where('status', 'active')
                        ->where('id', '!=', $blog->id)
                        ->latest('published_at')
                        ->limit(4)
                        ->get();
                @endphp

                @if($recentBlogs->count())
                <div class="card border-0 shadow-sm mb-4" style="border-radius:12px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3" style="font-weight:700; color:#2d3748;">Recent Posts</h5>
                        @foreach($recentBlogs as $recent)
                        <div class="d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            @if($recent->image)
                                <a href="{{ route('blogs.detail', $recent->slug) }}">
                                    <img src="{{ asset('storage/' . $recent->image) }}" alt="{{ $recent->title }}"
                                        style="width:70px; height:55px; object-fit:cover; border-radius:8px; flex-shrink:0;">
                                </a>
                            @else
                                <div style="width:70px; height:55px; background:linear-gradient(135deg,#667eea,#764ba2); border-radius:8px; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-newspaper text-white small"></i>
                                </div>
                            @endif
                            <div class="ml-3">
                                <a href="{{ route('blogs.detail', $recent->slug) }}" style="font-weight:600; color:#2d3748; font-size:0.9rem; text-decoration:none; line-height:1.3; display:block;">
                                    {{ Str::limit($recent->title, 55) }}
                                </a>
                                <small class="text-muted">
                                    {{ $recent->published_at ? $recent->published_at->format('d M Y') : $recent->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Emergency CTA -->
                <div class="card border-0 text-white" style="background:linear-gradient(135deg,#e53e3e,#c53030); border-radius:12px;">
                    <div class="card-body p-4 text-center">
                        <i class="fas fa-ambulance fa-2x mb-3"></i>
                        <h5 class="mb-2" style="font-weight:700;">Need an Ambulance?</h5>
                        <p class="small mb-3 opacity-75">Fast, reliable emergency medical transportation in Pune.</p>
                        <a href="{{ route('nonemergency') }}" class="btn btn-light btn-sm" style="border-radius:20px; font-weight:600; color:#e53e3e;">
                            Book Now
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection
