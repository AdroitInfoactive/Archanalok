<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }


        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        <blade media|%20screen%20and%20(max-width%3A%20480px)%20%7B>.mobile-hide {
            display: none !important;
        }

        .mobile-center {
            text-align: center !important;
        }
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>

<body style="margin: 0 !important; padding: 0 !important; background-color: #eeeeee;" bgcolor="#eeeeee">


    <div
        style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Open Sans, Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        For what reason would it be advisable for me to think about business content? That might be little bit risky to
        have
        crew member like them.
    </div>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" style="background-color: #eeeeee;" bgcolor="#eeeeee">

                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:600px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0; padding: 35px;" bgcolor="#fff">

                            <div style="display:inline-block; min-width:100px; vertical-align:top; width:100%;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                                    style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top"
                                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 800; line-height: 48px;"
                                            class="mobile-center">
                                            <img src="http://127.0.0.1:8000/{{ config('settings.logo') }}"
                                                alt="Archanalok Logo">
                                            <!-- <h1 style="font-size: 36px; font-weight: 800; margin: 0; color: #ffffff;">{{
                        config('settings.logo') }}</h1> -->
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff;"
                            bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="max-width:600px;">
                                <tr>
                                    <td align="center"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                                        <img src="http://127.0.0.1:8000/uploads/logos/check.png" width="125"
                                            height="120" style="display: block; border: 0px;" /><br>
                                        <h2
                                            style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                                            Thank You For Your Order!
                                        </h2>
                                    </td>
                                </tr>

                                @php
                                    $invoiceNo = 'ATC/' . $order->financial_year . '/' . str_pad(
                                        $order->id,
                                        3,
                                        '0',
                                        STR_PAD_LEFT
                                    );
                                    $formattedDate = $order->created_at->format('d-m-Y H:i:s');
                                @endphp
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left" bgcolor="#eeeeee"
                                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                                    Order Confirmation #
                                                </td>
                                                <td width="25%" align="left" bgcolor="#eeeeee"
                                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                                    {{ $invoiceNo }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="75%" align="left"
                                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                                    ORDER TOTAL
                                                </td>
                                                <td width="25%" align="left"
                                                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                                    {{ currencyPosition(@$order->grand_total) }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                    <!-- <tr>
            <td align="center" height="100%" valign="top" width="100%"
              style="padding: 0 35px 35px 35px; background-color: #ffffff;" bgcolor="#ffffff">
              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:660px;">
                <tr>
                  <td align="center" valign="top" style="font-size:0;">
                    <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">

                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="max-width:300px;">
                        <tr>
                          <td align="left" valign="top"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                            <p style="font-weight: 800;">Delivery Address</p>
                            <p>{{ $order->address }}</p>

                          </td>
                        </tr>
                      </table>
                    </div>
                    <div style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                      <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%"
                        style="max-width:300px;">
                        <tr>
                          <td align="left" valign="top"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; text-align:right;">
                            <p style="font-weight: 800;">Estimated Delivery Time</p>
                            <p>{{ @$order->address->deliveryArea->min_delivery_time }} - {{
                              @$order->address->deliveryArea->max_delivery_time }}</p>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr> -->

                    <tr>
                        <td align="center" style="padding: 35px; background-color: #ffffff;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                                style="max-width:600px;">
                                <tr>
                                    <td align="center">
                                        <img src="http://127.0.0.1:8000/{{ config('settings.logo') }}"
                                            width="37" height="37"
                                            style="display: block; border: 0px;" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px; padding: 5px 0 10px 0;">
                                        <p
                                            style="font-size: 14px; font-weight: 800; line-height: 18px; color: #333333;">
                                            19-4-418/1 to 9, Next to Metro Theatre,<br>
                                            Bhadarpura Circle
                                            Hyderabad - 500064(T.S)
                                            Telangana, India
                                        </p>
                                    </td>
                                </tr>
                                <!-- <tr>
                  <td align="left"
                    style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 24px;">
                    <p style="font-size: 14px; font-weight: 400; line-height: 20px; color: #777777;">
                      If you didn't create an account using this email address, please ignore this email
                    </p>
                  </td>
                </tr> -->
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>