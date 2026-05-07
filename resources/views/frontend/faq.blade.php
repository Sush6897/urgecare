@extends('layout.frontend.app')
@section('content')

<section class="page-title py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>Frequently Asked Questions</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="faq my-4">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="accordion" id="accordionFaq">
                        @forelse($faqs as $faq)
                        <div class="card">
                            <div class="card-header" id="heading{{ $faq->id }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link text-left {{ !$loop->first ? 'collapsed' : '' }}" type="button" data-toggle="collapse"
                                        data-target="#collapse{{ $faq->id }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $faq->id }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{ $faq->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading{{ $faq->id }}"
                                data-parent="#accordionFaq">
                                <div class="card-body">
                                    {!! nl2br(e($faq->answer)) !!}
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="alert alert-info">No FAQs found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>



@endsection