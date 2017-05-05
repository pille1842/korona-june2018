<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            @yield('title')
        </title>
        <style type="text/css">
            body {margin: 0; padding: 0; min-width: 100%!important;}
            .content {width: 100%; max-width: 600px; font-family: "Arial", sans-serif;}
            @media only screen and (min-device-width: 601px) {
                .content {width: 600px !important;}
            }
            .header {padding: 40px 30px 20px 30px; color: #ffffff;}
            .footer {margin-top: 20px; padding: 20px; text-align: center;}
        </style>
    </head>
    <body yahoo bgcolor="#f6f8f1">
        <!--[if (gte mso 9)|(IE)]>
            <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td>
                        <![endif]-->
                        <table class="content" align="center" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td class="header" bgcolor="#880000" fgcolor="#ffffff">
                                    @yield('header')
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @yield('content')
                                </td>
                            </tr>
                            <tr>
                                <td class="footer" bgcolor="#dddddd">
                                    <center>
                                        <p>Diese E-Mail wurde automatisch erstellt. Bitte
                                        nicht darauf antworten.</p>

                                        <p><a href="{{ url('/') }}">Korona</a></p>
                                    </center>
                                </td>
                            </tr>
                        </table>
                        <!--[if (gte mso 9)|(IE)]>
                    </td>
                </tr>
            </table>
        <![endif]-->
    </body>
</html>
