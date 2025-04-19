@extends('layouts.user_dashboard')
@section('dashboard-content')
    <style>
        /* Magazine Viewer Styles */
        .magazine-viewer-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        @media (min-width: 992px) {
            .magazine-viewer-container {
                flex-direction: row;
            }

            .magazine-list {
                width: 250px;
                flex-shrink: 0;
            }

            .pdf-viewer-wrapper {
                flex-grow: 1;
            }
        }

        .magazine-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            overflow-y: auto;
            max-height: 600px;
            padding-right: 10px;
        }

        .magazine-item {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .magazine-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .magazine-item.active {
            border-left: 4px solid #3f80ea;
            background-color: #f8f9fa;
        }

        .magazine-cover {
            position: relative;
        }

        .magazine-cover img {
            width: 100%;
            height: auto;
            display: block;
        }

        .magazine-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ff4757;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .magazine-info {
            padding: 12px;
        }

        .magazine-info h5 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .magazine-info p {
            margin: 5px 0 0;
            font-size: 13px;
            color: #777;
        }

        /* PDF Viewer Styles */
        .pdf-viewer-wrapper {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .pdf-toolbar {
            background: #f8f9fa;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #eee;
        }

        .btn-pdf-tool {
            background: none;
            border: none;
            color: #555;
            font-size: 16px;
            cursor: pointer;
            padding: 5px 8px;
            border-radius: 4px;
        }

        .btn-pdf-tool:hover {
            background: #e9ecef;
            color: #333;
        }

        .page-info {
            margin: 0 10px;
            font-size: 14px;
            color: #666;
        }

        .pdf-viewer {
            height: 600px;
            overflow-y: auto;
            padding: 20px;
            text-align: center;
            background: #f5f5f5;
        }

        .pdf-viewer img {
            max-width: 100%;
            height: auto;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="ec-vendor-block-profile">
                        <h4 class="dashboard-title mb-4">
                            {{ __('words.magazine_library') }}
                        </h4>

                        <!-- Magazine Viewer Container -->
                        <div class="magazine-viewer-container">
                            <!-- Magazine List -->
                            <div class="magazine-list">
                                @foreach ($archives as $archive)
                                    <div class="magazine-item @if ($loop->first) active @endif"
                                        data-pdf="{{ Storage::url($archive->pdf_file) }}">
                                        <div class="magazine-cover">
                                            <img src="{{ Voyager::image($archive->magazine->image) }}" alt="Tech Monthly">
                                            <div class="magazine-badge">New</div>
                                        </div>
                                        <div class="magazine-info">
                                            <h5>{{ $archive->magazine->name }}</h5>
                                            <p>{{ $archive->title }}</p>
                                        </div>
                                    </div>
                                @endforeach
                             
                            </div>

                            <!-- PDF Viewer -->
                            <div class="pdf-viewer-wrapper">
                                <div class="pdf-toolbar">
                                    <button class="btn-pdf-tool" title="Zoom In"><i class="fa fa-search-plus"></i></button>
                                    <button class="btn-pdf-tool" title="Zoom Out"><i
                                            class="fa fa-search-minus"></i></button>
                                    <button class="btn-pdf-tool" title="Previous Page"><i
                                            class="fa fa-arrow-left"></i></button>
                                    <span class="page-info">Page 1 of 24</span>
                                    <button class="btn-pdf-tool" title="Next Page"><i
                                            class="fa fa-arrow-right"></i></button>
                                    <button class="btn-pdf-tool" title="Fullscreen"><i class="fa fa-expand"></i></button>

                                </div>
                                <div class="pdf-viewer">
                                    <img src="{{ asset('images/magazines/preview1.jpg') }}" alt="Magazine Preview"
                                        class="img-fluid">
                                    <!-- In a real implementation, you would use a PDF viewer like PDF.js here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
