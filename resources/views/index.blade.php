<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css')  }}">
    <title>Photo</title>
</head>
<body>
    <div id="app"></div>
{{--    <div class="container mt-5">--}}
{{--        <h2>Laravel Captcha Code Example</h2>--}}
{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                <ul>--}}
{{--                    @foreach ($errors->all() as $error)--}}
{{--                        <li>{{ $error }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div><br />--}}
{{--        @endif--}}
{{--        <form method="post" action="{{url('captcha-validation')}}">--}}
{{--            @csrf--}}
{{--            <div class="form-group">--}}
{{--                <label>Name</label>--}}
{{--                <input type="text" class="form-control" name="name">--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label>Email</label>--}}
{{--                <input type="text" class="form-control" name="email">--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <label for="Password">Username</label>--}}
{{--                <input type="text" class="form-control" name="username">--}}
{{--            </div>--}}
{{--            <div class="form-group mt-4 mb-4">--}}
{{--                <div class="captcha">--}}
{{--                    <span>{!! captcha_img() !!}</span>--}}
{{--                    <button type="button" class="btn btn-danger" class="reload" id="reload">--}}
{{--                        &#x21bb;--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="form-group mb-4">--}}
{{--                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">--}}
{{--            </div>--}}
{{--            <div class="form-group">--}}
{{--                <button type="submit" class="btn btn-primary btn-block">Submit</button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
</body>
<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>
<script src="https://kit.fontawesome.com/66dfc7db4d.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}"></script>
{{--<script src="{{mix('js/app.js')}}"></script>--}}
</body>
</html>
