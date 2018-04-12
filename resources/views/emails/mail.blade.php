<html>        
<style>
	/* Image Surround Layout Pattern CSS */
	@media only screen and (max-width: 599px) {
        td[class="pattern"] img {
            width: 100%
            height: auto !important;
        }
        td[class="pattern"] img.cta {
            width: auto;
        }
        td[class="pattern"] table,
        td[class="pattern"] .row {
            width: 100%;
        }
        td[class="pattern"] .img {
            display: block;
            float: left;
            width: 25%;
        }
        td[class="pattern"] .middle {
            width: 50%;
        }
	}
    @media only screen and (max-width: 550px) {
        td[class="pattern"] .headline { font-size: 26px !important; }
    }
    @media only screen and (max-width: 460px) {
        td[class="pattern"] .row2 { padding: 40px 0; }
        td[class="pattern"] .headline { font-size: 42px !important; }
        td[class="pattern"] .body_copy { font-size: 16px !important; }
        td[class="pattern"] .hide { display: none; }
        td[class="pattern"] .img {
            width: 50%;
        }
        td[class="pattern"] .img img {
            width: 100%
        }
    }
</style>

<center>
<table cellpadding="0" cellspacing="0">
    <tr>
        <td class="pattern" width="600">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="row row1">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\1.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\2.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\3.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\4.png') }}" alt="" style="display: block; border: 0;" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="row row2">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="middle" width="900" align="center" valign="middle">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="headline" align="center" >
                                                <br>
                                                <img src="{{ $message->embed(public_path() . '\img\logo.png') }}" style="vertical-align: middle; width: 150px; height: 150px;">
                                                <br> 
                                            </td>
                                        </tr>
                                          <tr>
                                            <td class="headline" align="center" style="font-family: 'Segoe UI Light'; font-size: 35px; font-weight: bold;">
                                                <b>Office of the University Secretary</b>
                                                <br><hr>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="body_copy" align="center">
                                                <br>
                                                <h2 style="font-family: 'Segoe UI Light'; font-weight: lighter; display: inline;">The new document entitled</h2>
                                                <h2 style="font-family: 'Segoe UI Light'; font-weight: bolder; display: inline;" >{{ $title }}</h2> 
                                                <h2 style="font-family: 'Segoe UI Light'; font-weight: lighter; display: inline;">
                                                is awaiting for your approval.</h2>
                                                <br><br>
                                                <h3 style="font-family: 'Segoe UI Light'; font-weight: lighter;">
                                                The passcode needed to access the document in <a href="http://localhost:8000">USeP OSU</a> is: 
                                                </h3>
                                                <h1 style="font-family: 'Segoe UI Light'; font-size: 60px; font-weight: bold;">{{ $passcode }}</h1>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="row row3">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\5.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\6.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\7.png') }}" alt="" style="display: block; border: 0;" /></td>
                                <td class="img"><img src="{{ $message->embed(public_path() . '\img\8.png') }}" alt="" style="display: block; border: 0;" /></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

        

</center>
</html>