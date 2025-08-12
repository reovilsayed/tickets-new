@extends('layouts.user_dashboard')

@section('styles')
    <style>
        /* Magazine Viewer Styles */
        .magazine-viewer-container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
        }

        .magazine-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .magazine-header h2 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .magazine-header p {
            color: #7f8c8d;
        }

        .magazine-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            height: 100%;
        }

        .magazine-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .magazine-card.active {
            border: 2px solid #3f80ea;
        }

        .magazine-thumbnail {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .magazine-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .magazine-card:hover .magazine-thumbnail img {
            transform: scale(1.05);
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
            z-index: 2;
        }

        .magazine-info {
            padding: 15px;
        }

        .magazine-info h5 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #2c3e50;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .magazine-info p {
            margin: 0;
            font-size: 13px;
            color: #7f8c8d;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .magazine-actions {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-top: 1px solid #eee;
            background-color: #f9f9f9;
        }

        .btn-preview {
            background-color: #3f80ea;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.2s;
        }

        .btn-preview:hover {
            background-color: #336fd8;
            transform: translateY(-1px);
        }

        .btn-preview i {
            margin-right: 5px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .empty-state i {
            font-size: 50px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #7f8c8d;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-card-body">
            <div class="magazine-viewer-container">
                <div class="magazine-header">
                    <h2>Magazine Archives</h2>
                    <p>Browse through our collection of past magazine issues</p>
                </div>

                @if ($archives->count() > 0)
                    <div class="row">
                        @foreach ($archives as $archive)
                            <div class="col-md-4 col-sm-6 mb-4">
                                <div class="magazine-card">
                                    <div class="magazine-thumbnail">

                                        <img src="{{ Storage::url($archive->magazine->image) }}" alt="{{ $archive->title }}">


                                    </div>
                                    <div class="magazine-info">
                                        <h5>{{ $archive->magazine->name }}</h5>
                                        <p>{{ $archive->title }}</p>
                                    </div>
                                    <div class="magazine-actions">
                                        <span class="text-muted small">{{ $archive->created_at->format('M Y') }}</span>
                                        <a target="_blank" href="{{ route('user.magazine.pdf.view', $archive) }}"
                                            class="btn-preview">
                                            <i class="fas fa-eye"></i> Preview
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-book-open"></i>
                        <h3>No Magazines Available</h3>
                        <p>There are currently no magazine archives to display. Please check back later.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Highlight the clicked magazine card
            $('.magazine-card').click(function() {
                $('.magazine-card').removeClass('active');
                $(this).addClass('active');
            });

            // Prevent card click when clicking on preview button
            $('.btn-preview').click(function(e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection
