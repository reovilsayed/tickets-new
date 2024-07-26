@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))
<style>

</style>

@section('page_header')

@include('voyager::multilingual.language-selector')
@stop

@section('content')

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <title>Haladeals |Email</title>

    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;

            font-family: 'Rubik', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        .main {
            width: 650px;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        h5 {
            margin: 10px;
            color: #777;
        }

        .text-center {
            text-align: center
        }

        .header .header-logo a {
            display: block;
            margin: 0;
            padding: 25px 0 20px;
            text-align: center;
        }

        .review-name h5 {
            margin: 0;
            color: #232323;
            font-size: 18px;
            text-align: center;
            text-transform: capitalize;
            font-weight: 500;
        }

        .cart-button {
            text-transform: uppercase;
            margin: 0 auto;
            border-radius: 5px;
            padding: 13px 30px;
            border: 1px solid #e22454;
            color: #fff;
            font-size: 12px;
            background-color: #e22454;
            font-weight: 600;
        }

        table.order-detail {
            border: 1px solid #eff2f7;
            border-collapse: collapse;
            text-align: left;
        }

        table.order-detail tr:nth-child(even) {
            border-top: 1px solid #eff2f7;
            border-bottom: 1px solid #eff2f7;
        }

        table.order-detail tr:nth-child(odd) {
            border-bottom: 1px solid #eff2f7;
        }

        .order-detail th {
            font-size: 14px;
            padding: 15px;
            background: #eff2f7;
            font-weight: 500;
            text-transform: capitalize;
        }

        .order-detail tr td {
            padding: 12px;
        }

        .order-detail tr td h5 {
            margin: 15px 0 0;
            font-weight: 400;
            color: #232323;
        }
    </style>
</head>

<body style="margin: 20px auto;">
    <table class="main" align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: white; padding: 0 30px; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);  -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="header" style="display: block;">
                            <td class="header-logo" style="text-align: center; display: block;" align="top">
                                <a href="">
                                    <img style="height:130px;" src="{{Voyager::Image($dataTypeContent->shop->logo) }}" alt="Site Logo" />
                                </a>
                            </td>
                        </tr>
                        <td class="review-name" style="margin-bottom: 20px; display: block;">
                            <h5>{{ $dataTypeContent->shop->name }},</h5>

                        </td>

                            <td style="display:block;padding-bottom: 20px;color: #787771;margin-left:5px">
                                    <p style="margin: 0 10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                      <span style="font-weight: 700;margin-right:10px"> Name: </span> {{ $dataTypeContent->fullname }}
                                    </p>
                                    <p style="margin: 0 10px; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                    <span style="font-weight: 700;margin-right:10px"> Email: </span>{{ $dataTypeContent->email }}
                                    </p>
                                    <p style="margin: 0 10px; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                    <span style="font-weight: 700;margin-right:10px"> Phone: </span>{{ $dataTypeContent->phone }}
                                    </p>
                                    <p style="margin: 0 10px; margin-top:10px; font-size: 14px; text-align: left; mso-line-height-alt: 16.8px;">
                                    <span style="font-weight: 700;margin-right:10px"> Adress: </span> {{ $dataTypeContent->post_code }},{{ $dataTypeContent->city }},{{ $dataTypeContent->address }}
                                    </p>
                                </td>
                                <td style="display:block;padding-bottom: 20px;color: #787771;margin-left:15px">
                                    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px;">
                                        Order No: <span style="color:#c4a07a;"><strong>{{ $dataTypeContent->id }}</strong></span>
                                    </p>
                                    <p style="margin: 0; font-size: 14px; mso-line-height-alt: 16.8px; margin-top:10px">
                                        Order Date: {{ $dataTypeContent->created_at->format('M d, Y') }}
                                    </p>
                        </td>

                        <td style="margin-bottom: 20px; display: block;">
                            <h4 style="margin: 0px 0px 5px;font-weight: 500;margin-left:10px">Product Info</h4>
                            <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="left" style="width: 100%; margin-bottom: 20px;">
                                <tr align="left">
                                    <th>Image</th>
                                    <th>Item</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                </tr>

                                <tr>
                                    <td>
                                        <img src="{{ Storage::url($dataTypeContent->product->image) }}" alt="" width="100">
                                    </td>

                                    <td align="top">
                                        <h5 style="margin-top: 15px;">{{ $dataTypeContent->product->name }}
                                        </h5>
                                    </td>
                                    <td align="top">
                                        <h5 style="font-size: 14px; color:#444;margin-top: 15px;">{{ $dataTypeContent->quantity }}
                                        </h5>
                                    </td>

                                    <td align="top">
                                        <h5 style="font-size: 14px; color:#444;margin-top:15px">
                                            <b>{{ Sohoj::price($dataTypeContent->Product->price) }}</b>
                                        </h5>
                                    </td>
                                </tr>





                                <tr class="pad-left-right-space ">
                                    <td class="m-b-5" colspan="2" align="left">
                                        <h6 style="font-weight: 400;font-size: 14px; margin: 0;">Grand Total :</h6>
                                    </td>

                                    <td class="m-b-5" colspan="2" align="right">
                                        <h6 style="font-weight: 500;font-size: 14px; margin: 0;">{{ Sohoj::price($dataTypeContent->total) }}</h6>
                                    </td>
                                </tr>

                            </table>
                        </td>
                        <tr style="display: flex; justify-content:center;margin-bottom:30px;margin-top:20px">

                            <td>
                                <a class="cart-button" style="background-color:black;border:none;" href="{{ route('thankyou',$dataTypeContent) }}">complete
                                    checkout</a>
                            </td>

                        </tr>


                        <table class="text-center" align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #212529; color: white; padding: 40px 30px;">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon text-center" align="center" style="margin: 8px auto 20px;">
                                        <!-- <tr>
                                            <td>
                                                <img src="images/fb.png" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);" alt="">
                                            </td>
                                            <td>
                                                <img src="images/twitter.png" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);" alt="">
                                            </td>
                                            <td>
                                                <img src="images/insta.png" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);" alt="">
                                            </td>
                                            <td>
                                                <img src="images/pinterest.png" style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);" alt="">
                                            </td>
                                        </tr> -->
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>
                                                <h5 style="font-size: 13px; text-transform: uppercase; margin: 0; color:#ddd; letter-spacing:1px; font-weight: 500;text-align:center">
                                                    This email was created using the <span style="color: #f58888;">Halaldeals</span>.</h5>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100%">
                                                <table class="contact-table" style="width: 100%; margin-top: 10px;">
                                                    <tbody style="display: block; width: 100%;">
                                                        <tr style="display: block; width: 100%;display: flex; align-items: center; justify-content: center;">

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>

@stop

@section('javascript')
@if ($isModelTranslatable)
<script>
    $(document).ready(function() {
        $('.side-body').multilingual();
    });
</script>
@endif
<script>
    var deleteFormAction;
    $('.delete').on('click', function(e) {
        var form = $('#delete_form')[0];

        if (!deleteFormAction) {
            // Save form action initial value
            deleteFormAction = form.action;
        }

        form.action = deleteFormAction.match(/\/[0-9]+$/) ?
            deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
            deleteFormAction + '/' + $(this).data('id');

        $('#delete_modal').modal('show');
    });
</script>
@stop