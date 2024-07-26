<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="images/favicon.png" type="image/x-icon">

    <title>AhroMart |Email</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 650px;
            font-family: 'Rubik', sans-serif;
            background-color: #e2e2e2;
            display: block;
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
    <table align="center" border="0" cellpadding="0" cellspacing="0"
        style="background-color: white; width: 100%; padding: 0 30px; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);  -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);">
        <tbody>
            <tr>
                <td>
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="header" style="display: block;">
                            <td class="header-logo" style="text-align: center; display: block;" align="top">
                                <a href="">
                                    <img style="height:130px;"
                                        src="{{ asset('assets/frontend-assets/images/logo/logo-1.png') }}"
                                        alt="Site Logo" />
                                </a>
                            </td>
                        </tr>

                        {{ $slot }}
                        <table class="text-center" align="center" border="0" cellpadding="0" cellspacing="0"
                            width="100%" style="background-color: #212529; color: white; padding: 40px 30px;">
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0"
                                        class="footer-social-icon text-center" align="center"
                                        style="margin: 8px auto 20px;">
                                        <tr>
                                            <td>
                                                <img src="images/fb.png"
                                                    style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);"
                                                    alt="">
                                            </td>
                                            <td>
                                                <img src="images/twitter.png"
                                                    style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);"
                                                    alt="">
                                            </td>
                                            <td>
                                                <img src="images/insta.png"
                                                    style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);"
                                                    alt="">
                                            </td>
                                            <td>
                                                <img src="images/pinterest.png"
                                                    style="font-size: 25px; margin: 0 18px 0 0;width: 22px;filter: invert(1);"
                                                    alt="">
                                            </td>
                                        </tr>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>
                                                <h5
                                                    style="font-size: 13px; text-transform: uppercase; margin: 0; color:#ddd; letter-spacing:1px; font-weight: 500;">
                                                    This email was created using the <span
                                                        style="color: #f58888;">AhroMart</span>.</h5>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 100%">
                                                <table class="contact-table" style="width: 100%; margin-top: 10px;">
                                                    <tbody style="display: block; width: 100%;">
                                                        <tr
                                                            style="display: block; width: 100%;display: flex; align-items: center; justify-content: center;">

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
