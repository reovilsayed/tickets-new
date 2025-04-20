@extends('layouts.user_dashboard')

{{-- <style>
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
        flex-wrap: wrap;
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
        position: relative;
    }

    #pdf-canvas {
        max-width: 100%;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
    }

    .pdf-loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 10;
    }

    .pdf-loading-overlay p {
        margin-top: 15px;
        font-size: 16px;
        color: #333;
    }
</style> --}}
@section('styles')
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

        .pdf {
            width: 100%;
            aspect-ratio: 4 / 3;
            border: none;
        }
    </style>
    <style>

    </style>
@endsection
@section('dashboard-content')
    <div class="ec-shop-rightside col-lg-9 col-md-12">
        <div class="ec-vendor-card-body">
            <div class="row">

                

                <!-- Magazine Viewer Container -->
                <div class="">
                    <!-- Magazine List -->
                    <div class="">
                        <div class="table-responsive">
                            <table class="table table-dark table-hover table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Magazine Name</th>
                                        <th>Archive Title</th>
                                     
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($archives as $index => $archive)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $archive->magazine->name }}</td>
                                            <td>{{ $archive->title }}</td>
                                        
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a target="_blank" href="{{route('user.magazine.pdf.view',$archive)}}" class="btn btn-sm btn-primary" >
                                                        <i class="fas fa-eye"></i> Preview
                                                    </a>
                                                   
                                                </div>

                                          
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- PDF Viewer -->
                    {{-- <div class="pdf-viewer-wrapper">
                                <div class="pdf-toolbar">
                                    <button id="zoom-in" class="btn-pdf-tool" title="Zoom In">
                                        <i class="fa fa-search-plus"></i>
                                    </button>
                                    <button id="zoom-out" class="btn-pdf-tool" title="Zoom Out">
                                        <i class="fa fa-search-minus"></i>
                                    </button>
                                    <button id="prev" class="btn-pdf-tool" title="Previous Page">
                                        <i class="fa fa-arrow-left"></i>
                                    </button>
                                    <span class="page-info">
                                        <span id="page-num">1</span> / <span id="page-count">0</span>
                                    </span>
                                    <button id="next" class="btn-pdf-tool" title="Next Page">
                                        <i class="fa fa-arrow-right"></i>
                                    </button>
                                    <button id="fullscreen" class="btn-pdf-tool" title="Fullscreen">
                                        <i class="fa fa-expand"></i>
                                    </button>
                               
                                </div>
                                <div class="pdf-viewer" id="image-viewer">
                                    @if (isset($archives[0]->preview_image))
                                        <img src="{{ $archives[0]->preview_image }}" alt="Magazine Preview"
                                            class="magazine-preview-img" id="preview-image">
                                    @else
                                        <div class="no-preview">
                                            <i class="fa fa-file-pdf-o"></i>
                                            <p>Preview not available</p>
                                        </div>
                                    @endif
                                </div>
                            </div> --}}
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
{{-- <script>
    // Set the worker path for PDF.js
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1.0;

    // Initialize PDF viewer
    function initPdfViewer(pdfUrl) {
        // Show loading indicator
        document.getElementById('pdf-loading').style.display = 'flex';

        // Load the PDF
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
            pdfDoc = pdf;
            document.getElementById('page-count').textContent = pdf.numPages;

            // Reset to first page
            pageNum = 1;
            renderPage(pageNum);

            // Set download link
            document.getElementById('download-pdf').href = pdfUrl;
        }).catch(function(error) {
            console.error('Error loading PDF:', error);
            alert('Error loading PDF. Please try again.');
        });
    }

    // Render a page
    function renderPage(num) {
        pageRendering = true;

        pdfDoc.getPage(num).then(function(page) {
            const viewport = page.getViewport({
                scale: scale
            });
            const canvas = document.getElementById('pdf-canvas');
            const ctx = canvas.getContext('2d');

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            page.render(renderContext).promise.then(function() {
                pageRendering = false;
                document.getElementById('pdf-loading').style.display = 'none';
                document.getElementById('page-num').textContent = num;

                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });
    }

    // Event listeners for magazine items
    document.querySelectorAll('.magazine-item').forEach(item => {
        item.addEventListener('click', function() {
            const pdfUrl = this.getAttribute('data-pdf');
            initPdfViewer(pdfUrl);

            // Update active state
            document.querySelectorAll('.magazine-item').forEach(i => {
                i.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Load first PDF by default
    const firstPdf = document.querySelector('.magazine-item.active')?.getAttribute('data-pdf');
    if (firstPdf) initPdfViewer(firstPdf);
</script> --}}
