<!doctype html>
<html lang="en">

<head>
    <title>Pihu</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">

</head>

<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">Forgot Password</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-6 p-5 custom-border">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center">You forgot your password? Here you can easily retrieve a new
                            password.</h3>
                        <form action="{{ route('forgot-password') }}" method="POST" class="signin-form">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            @if ($errors->has('email'))
                                <span class="alert-danger">{{ $errors->first('email') }}</span>
                            @endif
                            <div class="form-group">
                                <input id="password-field" type="password" name="newpassword" class="form-control"
                                    placeholder="New Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                @if ($errors->has('newpassword'))
                                    <span class="alert-danger">{{ $errors->first('newpassword') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input id="password-field" type="password" name="confirmpassword" class="form-control"
                                    placeholder="Confirm Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                @if ($errors->has('confirmpassword'))
                                    <span class="alert-danger">{{ $errors->first('confirmpassword') }}</span>
                                @endif
                            </div>


                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Submit</button>
                            </div>
                            <div class="form-group d-md-flex justify-content-end">
                                <div class="w-50 text-md-right">
                                    <a href="{{ route('login') }}" style="color: #fff">Login here?</a>
                                </div>
                            </div>
                        </form>
                        {{-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
                        <div class="social d-flex text-center">
                            <a href="#" class="px-2 py-2 mr-md-1 rounded"><span
                                    class="ion-logo-facebook mr-2"></span> Facebook</a>
                            <a href="#" class="px-2 py-2 ml-md-1 rounded"><span
                                    class="ion-logo-twitter mr-2"></span> Twitter</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

</body>

</html>
