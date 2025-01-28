@extends('voyager::master')

@section('page_title', "{$event->title} Participants")
@section('css')
  <style>
    .card {
      text-align: center;
      padding: 20px;
      width: 100%;
      border-radius: 10px;

      border: 2px solid #EF5927 !important;
      transition: .2s ease-in;
    }

    .card:hover {
      box-shadow: 5px 5px #EF5927;
    }

    .card h3 {
      text-transform: uppercase;
      font-weight: bold;
      margin: 0px;
      font-size: 30px;
      color: #EF5927;
      font-family: Arial, Helvetica, sans-serif;
    }

    .card h1 {
      font-size: 70px;
      font-weight: bold;
      color: #000;
    }

    h1 {
      font-size: 40px;
      font-weight: bold;
      color: #000;
    }
  </style>
@endsection

@section('content')
  <div class="container">
    <h1>
      {{ $event->name }} - Analytics
    </h1>

    <hr>
    @include('vendor.voyager.events.partial.buttons')
    <hr>
    <div class="container">

      <div class="panel panel-body">
        <ul class="nav nav-pills">
          <li class="active"><a data-toggle="pill" href="#byChart">{{ __('words.report_by_chart') }}</a></li>
          <li><a data-toggle="pill" href="#byDate">{{ __('words.report_by_date') }}</a></li>
          <li><a data-toggle="pill" href="#byReport">{{ __('words.report_by_type') }}</a></li>

        </ul>

        <div class="tab-content">
          <div id="byChart" class="tab-pane fade in active">
            <h3>{{ __('words.report_by_date_chart') }}</h3>
            <br>
            <br>
            <div class="row">
              <div class="col-12">
                {!! $ticketSoldChart->container() !!}
              </div>
            </div>
          </div>
          <div id="byDate" class="tab-pane fade">
            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="pill" href="#date_paid">{{ __('words.paid_ticket') }}</a></li>
              <li><a data-toggle="pill" href="#date_invite">{{ __('words.invite_ticket') }}</a></li>
            </ul>
            <div class="tab-content">
              <div id="date_paid" class="tab-pane fade in active">
                <div class="row ">
                  <h3>{{ __('words.report_by_date_paid_title') }}</h3>
                  <br>
                  <br>
                  @foreach ($report['by_dates'] as $date => $data)
                    <div class="col-md-6">
                      <div class="panel panel-bordered" style="box-shadow: 5px 5px 10px #0000005e">
                        <div class="panel-body">
                          <h3 class="text-center">
                            {{-- {{ Carbon\Carbon::parse($date)->format('d M y') }} --}}
                            {{ $date }}
                          </h3>
                          <p class="text-center text-primary">
                            {{ $data['products']->pluck('name')->implode(', ') }}
                          </p>
                          <div class="row">
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.participants') }}
                              </h4>
                              <h2>
                                {{ $data['type']['paid']['participants'] }}
                              </h2>
                            </div>
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.checked_in') }}
                              </h4>
                              <h2>
                                {{ $data['type']['paid']['checked_in'] }}
                              </h2>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%">
                              <span class="sr-only">
                                {{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%
                                Complete
                              </span>
                            </div>
                          </div>

                          <button type="button" class="btn btn-info btn-lg" data-json="{{ json_encode($data) }}" data-title="{{ $date }}" data-toggle="modal" data-target="#myModal">View</button>
                          {{-- <button type="button" class="btn btn-info btn-lg" data-json="{{ json_encode($data) }}" data-title="{{ $date }}" data-toggle="modal" data-target="#myModalType">View</button> --}}
                        </div>

                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div id="byReport" class="tab-pane fade">

            <ul class="nav nav-pills">
              <li class="active"><a data-toggle="pill" href="#paid">{{ __('words.paid_ticket') }}</a></li>
              <li><a data-toggle="pill" href="#invite">{{ __('words.invite_ticket') }}</a></li>
            </ul>
            <div class="tab-content">

              <div id="paid" class="tab-pane fade in active">
                <h3>{{ __('words.report_by_type_paid_title') }}</h3>
                <br>
                <br>
                <div class="row">
                  @foreach ($report['by_type']['paid']['products'] as $data)
                    <div class="col-md-6">
                      <div class="panel panel-bordered" style="box-shadow: 5px 5px 10px #0000005e">
                        <div class="panel-body">
                          <h3 class="text-center">
                            {{ $data['product']->name }}
                          </h3>

                          <p class="text-center text-primary">
                            {{ implode(', ', array_map(fn($date) => Carbon\Carbon::parse($date)->format('d M'), $data['product']->dates)) }}
                          </p>
                          <div class="row">
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.participants') }}
                              </h4>
                              <h2>
                                {{ $data['participants'] }}
                              </h2>
                            </div>
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.checked_in') }}
                              </h4>
                              <h2>
                                {{ $data['checked_in'] }}
                              </h2>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%">
                              <span class="sr-only">{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%
                                Complete</span>
                            </div>
                          </div>
                          <button type="button" class="btn btn-info btn-lg" data-json="{{ json_encode($data) }}" data-title="{{ $data['product']->name }}" data-toggle="modal" data-target="#myModalType">View</button>
                        </div>

                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
              <div id="invite" class="tab-pane fade">
                <h3>{{ __('words.report_by_type_invite_title') }}</h3>
                <br>
                <br>
                <div class="row">
                  @foreach ($report['by_type']['invite']['products'] as $data)
                    <div class="col-md-6">
                      <div class="panel panel-bordered" style="box-shadow: 5px 5px 10px #0000005e">
                        <div class="panel-body">
                          <h3 class="text-center">
                            {{ $data['product']->name }}
                          </h3>

                          <p class="text-center text-primary">
                            {{ implode(', ', array_map(fn($date) => Carbon\Carbon::parse($date)->format('d M'), $data['product']->dates)) }}
                          </p>
                          <div class="row">
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.participants') }}
                              </h4>
                              <h2>
                                {{ $data['participants'] }}
                              </h2>
                            </div>
                            <div class="col-md-6 text-center">
                              <h4>
                                {{ __('words.checked_in') }}
                              </h4>
                              <h2>
                                {{ $data['checked_in'] }}
                              </h2>
                            </div>
                          </div>
                          <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%">
                              <span class="sr-only">
                                {{ $data['participants'] ? round(($data['checked_in'] / $data['participants']) * 100) : 0 }}%
                                Complete
                              </span>
                            </div>
                          </div>
                          <button type="button" class="btn btn-info btn-lg" data-json="{{ json_encode($data) }}" data-title="{{ $data['product']->name }}" data-toggle="modal" data-target="#myModalType">View</button>
                        </div>

                      </div>
                    </div>
                  @endforeach
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>


    </div>
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="myModalTitle">

            </h4>
          </div>
          <div class="modal-body" id="myModalBody">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

    <div class="modal fade" id="myModalType" role="dialog">
      <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title" id="myModalTypeTitle">

            </h4>
          </div>
          <div class="modal-body" id="myModalTypeBody">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection

@section('javascript')
  <script>
    [...document.querySelectorAll("[data-target='#myModal']")].forEach(element => {
      element.addEventListener("click", function(e) {
        document.getElementById('myModalBody').innerHTML = '';
        let data = JSON.parse(e.target.dataset.json);
        let html = `   <h3 class="text-center text-primary">
                        {{ __('words.paid_ticket_and_invite') }}
                    </h3>

                    <hr>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.participants') }}
                            </h4>
                            <h2>
                                ${data.participants}
                            </h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.checked_in') }}
                            </h4>
                            <h2>
                               ${data.checked_in}
                            </h2>
                        </div>
                        <div class="col-4 text-center">

                            <h4>
                                {{ __('words.returned') }}
                            </h4>
                            <h2>
                               ${data.returned}
                            </h2>
                        </div>
                    </div>
                    <h3 class="text-center text-primary">
                        {{ __('words.paid_ticket') }}
                    </h3>

                    <hr>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.participants') }}
                            </h4>
                            <h2>
                                 ${data.type.paid.participants}
                            </h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.checked_in') }}
                            </h4>
                            <h2>
                               ${data.type.paid.checked_in}
                            </h2>
                        </div>
                        <div class="col-4 text-center">

                            <h4>
                                {{ __('words.returned') }}
                            </h4>
                            <h2>
                                 ${data.type.paid.returned}
                            </h2>
                        </div>
                    </div>
                    <h3 class="text-center text-primary">
                       {{ __('words.invite_ticket') }}
                    </h3>

                    <hr>
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.participants') }}
                            </h4>
                            <h2>
                                 ${data.type.invite.participants}
                            </h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.checked_in') }}
                            </h4>
                            <h2>
                                ${data.type.invite.checked_in}
                            </h2>
                        </div>
                        <div class="col-4 text-center">

                            <h4>
                                {{ __('words.returned') }}
                            </h4>
                            <h2>
                                ${data.type.invite.returned}
                            </h2>
                        </div>
                    </div>`;

        document.getElementById('myModalBody').innerHTML = html;
        document.getElementById('myModalTitle').innerText = e.target.dataset.title;
        console.log(data);
      })
    });
    [...document.querySelectorAll("[data-target='#myModalType']")].forEach(element => {
      element.addEventListener("click", function(e) {
        document.getElementById('myModalTypeBody').innerHTML = '';
        let data = JSON.parse(e.target.dataset.json);
        let html = `

                    <div class="row">
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.participants') }}
                            </h4>
                            <h2>
                                ${data.participants}
                            </h2>
                        </div>
                        <div class="col-md-4 text-center">
                            <h4>
                                {{ __('words.checked_in') }}
                            </h4>
                            <h2>
                               ${data.checked_in}
                            </h2>
                        </div>
                        <div class="col-4 text-center">

                            <h4>
                                {{ __('words.returned') }}
                            </h4>
                            <h2>
                               ${data.returned}
                            </h2>
                        </div>
                    </div>`;

        document.getElementById('myModalTypeBody').innerHTML = html;
        document.getElementById('myModalTypeTitle').innerText = e.target.dataset.title;
        console.log(data);
      })
    });
  </script>
  <script src="{{ $ticketSoldChart->cdn() }}"></script>
  <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
  {{ $ticketSoldChart->script() }}
@endsection