@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <style>
    .scanner-page {
      min-height: 100vh;
      background-color: #f36a30;
    }

    .status {
      padding: 10px;
    }

    .status .box {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .status .box img {
      height: 150px;
      width: 150px;
    }

    .status .box h3 {
      color: #000;
      font-weight: 700;
    }

    .scanner-header {
      min-height: 30vh;
    }

    .scanner-header h4 {
      margin: 0px;
    }

    .scanner-header .event-name {
      background-color: #fff;
      padding: 20px 10px;
      text-align: center;
      font-weight: bold;
      color: black;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .scanner-header .door-name {
      padding: 20px 10px !important;
      text-align: center;
      font-weight: bold;
      color: #fff;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    .add-new-session {
      transition: .2s ease-in;
      padding: 10px;
      text-align: center;
      color: black;
      background-color: #fff;
      width: 100%;
      margin-bottom: 2px;
    }

    .add-new-session:hover {
      background-color: #cfc1bb !important;
    }

    .scanner-inner {
      padding-top: 20px;
      min-height: 70vh;
      display: flex;
      flex-direction: column;
      justify-content: start;
      align-items: center;
    }

    .qr-image {
      height: 150px;
      width: 150px;
    }

    .qr-box h3 {
      font-family: Georgia, 'Times New Roman', Times, serif;
      font-weight: thin;
      color: #fff;
      text-transform: lowercase;
    }

    .qr-box {
      cursor: pointer;
      gap: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    .qr-box:hover .qr-image {
      transform: scale(1.1);
    }

    #video-container {
      position: relative;
      display: flex;
      justify-content: center !important;
      align-items: center !important;
      width: 100%;
    }

    #qr-video {
      width: 100%;
      overflow: hidden;
    }

    #viewfinder {
      display: none;
    }

    .status {
      background-color: #fff;
    }

    .content-wrapper {
      max-height: 100px;
      overflow: scroll;
      transition: max-height 0.3s ease;
    }
  </style>
@endsection

@section('content')
  <section class="scanner-page">
    <br><br><br>
    <div class="scanner-header">
      <h4 class="event-name">{{ $event->name }}</h4>
      <h4 class="door-name">{{ $zone->name }}</h4>
      <a href="{{ route('zone.enter') }}" class="add-new-session">Add new session</a>
      <div class="form-group">
        <select class="form-control text-center w-50 mx-auto" name="mode" id="mode">
          <option value="check-in">{{ __('words.check_in_mode') }}</option>
          <option value="check-out">{{ __('words.check_out_mode') }}</option>
        </select>
      </div>
    </div>

    <div class="scanner-inner">
      <div class="mobile-only d-block d-sm-none">
        <div class="qr-box" id="qrbox">
          <img class="qr-image" src="{{ asset('assets/qr-code.png') }}" alt="">
          <h3>Tap to read code</h3>
        </div>

        <div id="viewfinder" class="qr-box">
          <div id="video-container">
            <video id="qr-video"></video>
          </div>
        </div>
      </div>
      <!-- Add manual code input -->
      <div class="card d-none d-sm-block">
        <div class="card-body">
          <p>{{ __('words.enter_manually') }}</p>
          <div class="manual-entry d-flex align-items-center">
            <div>
              <input type="text" id="manual-input" class="border border-dark rounded p-1 m-0" placeholder="Enter code manually">
            </div>
            <div>
              <button id="submit-manual-code" class="btn btn-primary btn-sm m-0"><i class="fa fa-keyboard"></i> </button>
            </div>
          </div>
        </div>
      </div>

      <div class="container mt-4 d-none d-sm-block">
        <form class="d-flex mb-3" role="search">
          <input class="form-control me-2" type="search" name="q" placeholder="Search" aria-label="Search">
          <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <div class="row">
          <table class="table table-primary">
            <thead>
              <tr style="background-color:#EF5927">
                <td class="text-center">{{ __('words.name') }}</td>
                <td class="text-center">{{ __('words.email') }}</td>
                <td class="text-center">{{ __('words.phone') }}</td>
                <td class="text-center">{{ __('words.id') }}</td>
                <td class="text-center">{{ __('words.usage') }}</td>
                <td class="text-center">{{ __('words.logs') }}</td>
                <td class="text-center">{{ __('words.action') }}</td>
              </tr>
            </thead>
            <tbody id="ticket-list">
              @foreach ($tickets as $ticket)
                <tr class="text-center">
                  <td>
                    {{ $ticket->user ? $ticket->user->name . ' ' . $ticket->user->l_name : 'N/A' }}
                  </td>
                  <td>{{ $ticket->user ? $ticket->user->email : 'N/A' }}</td>
                  <td>{{ $ticket->user ? $ticket->user->contact_number : 'N/A' }}</td>
                  <td>{{ $ticket->ticket }}</td>
                  <td>{{ $ticket->product->name }}</td>
                  <td>
                    <div class="content-wrapper">
                      @foreach ($ticket->scans as $scan)
                        <p class="mb-1 text-{{ $scan->isCheckedIn() ? 'success' : 'danger' }}">
                          {{ $scan->action }} - {{ $scan->created_at->format('d M y g:i A') }}
                        </p>
                      @endforeach
                    </div>
                  </td>
                  <td>
                    @if (!$ticket->is_checked_in)
                      <a href="{{ route('zone.checkin', [$zone, $ticket->ticket]) }}" class="btn btn-success ticket-action">{{ __('words.check_in') }}</a>
                    @endif
                    @if ($ticket->is_checked_in === 1 && !$ticket->product->one_time)
                      <a href="{{ route('zone.checkout', [$zone, $ticket->ticket]) }}" class="btn btn-danger ticket-action">{{ __('words.check_out') }}</a>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          {{ $tickets->links('pagination::bootstrap-4') }}
        </div>
      </div>

    </div>
  </section>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script src="{{ asset('assets/js/qr/qr-scanner.min.js') }}" type="module"></script>
  <script type="module">
    import QrScanner from "{{ asset('assets/js/qr/qr-scanner.min.js') }}";

    const video = document.getElementById('qr-video');
    const qrBox = document.querySelector('.qr-box');
    const viewfinder = document.getElementById('viewfinder');
    const manualInput = document.getElementById('manual-input');
    const submitButton = document.getElementById('submit-manual-code');

    function setResult(result) {
      scanner.stop();

      const checkInMode = document.getElementById('mode').value;

      let url = checkInMode === 'check-in' ?
        "{{ route('zone.checkin', [$zone, '/ticket/']) }}" :
        "{{ route('zone.checkout', [$zone, '/ticket/']) }}";

      url = url.replace('/ticket/', result.data);

      axios.get(url)
        .then(res => {
          if (res.data.hasError) {
            toastr.error(res.data.msg);
            return;
          }

          toastr.success(res.data.msg)
        })
        .catch(err => {
          if (err.status === 404) {
            toastr.error("{{ __('words.ticket_not_found') }}");
          }
          throw err;
        });

      // fetch("{{ route('api.scan-ticket') }}", {
      //     method: "POST",
      //     body: JSON.stringify({
      //       ticket: result.data,
      //       zone: "{{ $zone->id }}",
      //       mode: document.getElementById('mode').value,
      //       user: "{{ auth()->id() }}",
      //       session: "{{ session()->get('enter-zone')['id'] }}",
      //       checksum: "{{ Hash::make(env('SECURITY_KEY')) }}"
      //     }),
      //     headers: {
      //       "Content-type": "application/json; charset=UTF-8"
      //     }
      //   }).then((response) => response.json())
      //   .then((json) => {});
      qrBox.style.display = 'flex';
      viewfinder.style.display = 'none';
    }

    const scanner = new QrScanner(video, result => setResult(result), {
      highlightScanRegion: true,
      highlightCodeOutline: true,
    });

    document.getElementById('qrbox').addEventListener('click', function() {
      qrBox.style.display = 'none';
      viewfinder.style.display = 'block';
      scanner._updateOverlay()
      scanner.start();
    });

    submitButton.addEventListener('click', () => {
      const manualCode = manualInput.value.trim();
      if (manualCode) {
        setResult({
          data: manualCode
        });
      }
    });

    window.addEventListener('unload', () => {
      scanner.stop();
    });

    document.getElementById('ticket-list').addEventListener('click', (e) => {
      if (e.target.classList.contains('ticket-action')) {
        const csk = confirm('Are you sure?');

        if (!csk) {
          e.preventDefault();
        }
      }
    });
  </script>

  @if (session()->has('error'))
    <script>
      toastr.error("{{ session('error') }}");
    </script>
  @endif

  @if (session()->has('success'))
    <script>
      toastr.success("{{ session('success') }}");
    </script>
  @endif
@endsection
