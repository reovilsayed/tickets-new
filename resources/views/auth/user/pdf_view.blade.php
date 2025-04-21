@extends('layouts.app')


@section('content')
@section('css')
    <style>
        .pdf {
            width: 100%;
            aspect-ratio: 4 / 3;
            border: none;
        }
    </style>
@endsection
{{-- <x-app.header /> --}}
{{-- <x-app.breadcrumb /> --}}


<!-- Vendor dashboard section -->
<section class="ec-page-content ec-vendor-dashboard section-space-p">
    <div class="container">
        <div class="row">
            <embed class="pdf"
                src="https://docs.google.com/gview?url={{ Storage::url($archive->pdf_file) }}&embedded=true">
            </embed>

        </div>
    </div>
</section>
@endsection
