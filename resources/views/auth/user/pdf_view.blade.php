{{-- @extends('layouts.app')


@section('content')
@section('css')
    <style>
        .pdf {
            width: 100%;
            aspect-ratio: 4 / 3;
            border: none;
        }
    </style>
@endsection --}}
{{-- <x-app.header /> --}}
{{-- <x-app.breadcrumb /> --}}


<!-- Vendor dashboard section -->
{{-- <section class="ec-page-content ec-vendor-dashboard section-space-p">
    <div class="container">
        <div class="row">
            <embed class="pdf"
                src="https://docs.google.com/gview?url={{ Storage::url($archive->pdf_file) }}&embedded=true">
            </embed>

        </div>
    </div>
</section>
@endsection --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$archive->title}}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #pdf-viewer {
            border: 1px solid #ccc;
            margin-top: 20px;
            width: 100%;
            max-width: 800px;
        }
        #navigation {
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>PDF Viewer</h1>

<canvas id="pdf-viewer"></canvas>

<div id="navigation">
    <button id="prev">Previous Page</button>
    <span>Page: <span id="page_num"></span> / <span id="page_count"></span></span>
    <button id="next">Next Page</button>
</div>
@dd(Storage::url($archive->pdf_view))

<script>
    // URL of your PDF (make sure nid.pdf is in same folder)
    const url = '{{ asset("storage/archives/" . $archive->pdf_view) }}';


    console.log(url)

    // Setting worker
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pdfDoc = null,
        pageNum = 1,
        pageRendering = false,
        pageNumPending = null,
        scale = 1.5,
        canvas = document.getElementById('pdf-viewer'),
        ctx = canvas.getContext('2d');

    function renderPage(num) {
        pageRendering = true;
        pdfDoc.getPage(num).then(function(page) {
            const viewport = page.getViewport({scale: scale});
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };
            const renderTask = page.render(renderContext);

            renderTask.promise.then(function() {
                pageRendering = false;
                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        // Update page counters
        document.getElementById('page_num').textContent = num;
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function onPrevPage() {
        if (pageNum <= 1) {
            return;
        }
        pageNum--;
        queueRenderPage(pageNum);
    }

    function onNextPage() {
        if (pageNum >= pdfDoc.numPages) {
            return;
        }
        pageNum++;
        queueRenderPage(pageNum);
    }

    // Event listeners for buttons
    document.getElementById('prev').addEventListener('click', onPrevPage);
    document.getElementById('next').addEventListener('click', onNextPage);

    // Load the PDF
    pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
        pdfDoc = pdfDoc_;
        document.getElementById('page_count').textContent = pdfDoc.numPages;

        // Initial render
        renderPage(pageNum);
    }).catch(function(error) {
        console.error('Error during PDF loading: ', error);
    });

</script>

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Disable right-click on the entire document, including the PDF
      document.addEventListener('contextmenu', function(event) {
        event.preventDefault();
      });
      
      // Optionally, you can also add a custom event listener to prevent right-click on the PDF element itself
      const pdfEmbed = document.querySelector('.pdf-viewer');
      if (pdfEmbed) {
        pdfEmbed.addEventListener('contextmenu', function(event) {
          event.preventDefault();
        });
      }
    });
  </script>  --}}
</body>
</html>

