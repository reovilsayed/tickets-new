@extends('layouts.app')
@section('content')
    <section class="rooms1 section-padding">
        <div class="container">
            <div class="row ">
                <div class="col-md-5 event-details">

                    <div class="event_img">
                        <img src=" {{ Voyager::image($product->image) }}" alt="">
                    </div>

                    <h2 class="events-title mt-5">{{ $product->name }}</h2>
                    <div class="accordins">
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-calendar fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    Start in 10 days
                                </h5>
                                <h6>
                                    9 Aug
                                </h6>
                                <h6>
                                    22:00 h
                                </h6>
                            </div>
                        </div>
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-location-pin fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    Location
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis libero sequi
                                    voluptates necessitatibus, consectetur excepturi esse sit beatae quos rem?
                                </p>
                            </div>
                        </div>
                        <div class="accordin-item">
                            <div>
                                <i class="fa fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5>
                                    Description
                                </h5>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perspiciatis libero sequi
                                    voluptates necessitatibus, consectetur excepturi esse sit beatae quos rem?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 event-box">
                    <ul class="nav nav-pills sec-hd mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                aria-selected="true">
                                <div class="days">
                                    <p class="days-select">ALL</p>
                                    <p class="info-date">DATE</p>
                                    <span class="dot"></span>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                                aria-selected="false">
                                <div class="days">
                                    <p class="days-select">09</p>
                                    <p class="info-date">AUG</p>
                                    <span class="dot"></span>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                                aria-selected="false">
                                <div class="days">
                                    <p class="days-select">10</p>
                                    <p class="info-date">AUG</p>
                                    <span class="dot"></span>
                                </div>
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">

                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-ticket">
                                <div class="card-body tick">
                                    <div class="ticket-info">
                                        <div class="t-info">
                                            <p class="t-date">09 AUG</p>
                                            <p class="t-title">Dia-9 Tz Da Coronel</p>
                                            <p class="t-des">Este bilhete garante entrada normal no dia 9 do Light
                                                Festival
                                            </p>
                                        </div>
                                        <div class="t-prize">
                                            <span class="text-dark me-2 ticket-prize">25€</span>
                                            <select class="form-select ticket-input" aria-label="Default select example">
                                                <option selected>0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <button class="event-buttton">
                        <span>Confirmed</span>
                        <span>25€ <i class="fa fa-arrow-right"></i></span>
                    </button>

                </div>

            </div>
        </div>
    </section>
@endsection
