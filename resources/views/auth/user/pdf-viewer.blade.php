<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" href="{{ asset('src/css/flipbook.min.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous"></script>

    <script src="{{ asset('src/js/flipbook.min.js') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            const pdfUrl = '{{ url('/pdf/' . $archive->pdf_file) }}';
            console.log('Loading PDF from:', pdfUrl);
            
            // Test PDF accessibility first
            fetch(pdfUrl, { method: 'HEAD' })
                .then(response => {
                    if (response.ok) {
                        console.log('PDF is accessible, initializing flipbook...');
                        initializeFlipbook(pdfUrl);
                    } else {
                        console.error('PDF not accessible:', response.status);
                        document.getElementById('container').innerHTML = '<div style="padding: 20px; text-align: center;"><h3>PDF Not Available</h3><p>Error loading PDF file. Please try again later.</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error checking PDF:', error);
                    document.getElementById('container').innerHTML = '<div style="padding: 20px; text-align: center;"><h3>PDF Not Available</h3><p>Error accessing PDF file. Please check your connection.</p></div>';
                });
            
            function initializeFlipbook(url) {
                jQuery('#container').flipBook({
                    pdfUrl: url,
                    pdfBrowserViewerIfMobile: false,
                    pdfBrowserViewerIfIE: false,
                    pdfBrowserViewerFullscreen: true,
                    pdfBrowserViewerFullscreenTarget: "_blank",
                    rangeChunkSize: 64,
                    disableRange: false,
                    disableStream: false,
                    disableAutoFetch: false,
                    pdfAutoLinks: true,
                    pdfjsworkerSrc: '{{ asset('src/js/libs/pdf.worker.min.js') }}',
                    loadPagesF: 3,
                    loadPagesB: 3,
                    pagesInMemory: 10,
                    onbookcreated: function() {
                        console.log('Flipbook created successfully');
                    },
                    onerror: function(error) {
                        console.error('Flipbook error:', error);
                    }
                });
            }
        });
    </script>
</head>

<body>
    <div id="container"></div>
</body>

</html>
