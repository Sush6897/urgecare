@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5" style="background: linear-gradient(135deg, #f8f9fa, #e9ecef);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="mb-2" style="font-weight:700; color:#2d3748;">Our Blog</h1>
                <p class="text-muted mb-0">Insights, health tips, and updates from Urgecare</p>
            </div>
        </div>
    </div>
</section>

<section class="blogs-listing py-5">
    <div class="container">

        @if($blogs->isEmpty())
            <div class="row">
                <div class="col-12 text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No blogs published yet.</h4>
                    <p class="text-muted">Check back soon for health tips and updates.</p>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($blogs as $blog)
                <div class="col-md-4 mb-4 d-flex align-items-stretch">
                    <div class="card border-0 shadow-sm w-100" style="border-radius:12px; overflow:hidden; transition: transform 0.2s, box-shadow 0.2s;">
                        <!-- Blog Image -->
                        <a href="{{ route('blogs.detail', $blog->slug) }}" style="text-decoration:none;">
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}"
                                    style="width:100%; height:200px; object-fit:cover;">
                            @else
                                <div style="width:100%; height:200px; background:linear-gradient(135deg,#667eea,#764ba2); display:flex; align-items:center; justify-content:center;">
                                    <i class="fas fa-newspaper fa-3x text-white opacity-75"></i>
                                </div>
                            @endif
                        </a>

                        <div class="card-body d-flex flex-column" style="padding:1.25rem;">
                            <!-- Category & Date -->
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                @if($blog->category)
                                    <span class="badge badge-pill" style="background:#e8f4fd; color:#2b6cb0; font-size:0.75rem; padding:5px 10px;">
                                        {{ $blog->category }}
                                    </span>
                                @else
                                    <span></span>
                                @endif
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $blog->published_at ? $blog->published_at->format('d M Y') : $blog->created_at->format('d M Y') }}
                                </small>
                            </div>

                            <!-- Title -->
                            <h5 class="card-title mb-2" style="font-weight:700; line-height:1.4;">
                                <a href="{{ route('blogs.detail', $blog->slug) }}" style="color:#2d3748; text-decoration:none;">
                                    {{ $blog->title }}
                                </a>
                            </h5>

                            <!-- Excerpt -->
                            @if($blog->excerpt)
                                <p class="card-text text-muted small flex-grow-1" style="line-height:1.6;">
                                    {{ Str::limit($blog->excerpt, 120) }}
                                </p>
                            @else
                                <p class="card-text text-muted small flex-grow-1" style="line-height:1.6;">
                                    {{ Str::limit(strip_tags($blog->content), 120) }}
                                </p>
                            @endif

                            <!-- Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3" style="border-top:1px solid #eee;">
                                @if($blog->author)
                                    <small class="text-muted">
                                        <i class="far fa-user mr-1"></i>{{ $blog->author }}
                                    </small>
                                @else
                                    <span></span>
                                @endif
                                <a href="{{ route('blogs.detail', $blog->slug) }}" class="btn btn-sm btn-primary" style="border-radius:20px; padding:4px 14px; font-size:0.8rem;">
                                    Read More <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
            <div class="row mt-3">
                <div class="col-12 d-flex justify-content-center">
                    {{ $blogs->links() }}
                </div>
            </div>
            @endif
        @endif

    </div>
</section>

<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.12) !important;
    }
</style>

@endsection
