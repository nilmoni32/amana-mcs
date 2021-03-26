<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/css/main.css">
  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="{{asset('assets')}}/css/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>{{ __('Login') }} - {{config('app.name')}}</title>
</head>

<body>
  <section class="material-half-bg">
    <div class="cover"></div>
  </section>
  <section class="login-content">
    <div class="logo">
      <h1>{{config('app.name')}}</h1>
    </div>
    <div class="login-box">
      <form class="login-form" action="{{ route('login.post') }}" method="POST" role="form">
        @csrf {{-- Used to protect the application from cross-site request forgery (CSRF) attacks --}}
        <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>{{ __('SIGN IN') }}</h3>
        <div class="form-group">
          <label class="control-label">{{ __('Email Address') }}</label>
          <input class="form-control" type="email" id="email" name="email" placeholder="Email Address" autofocus
            value={{ old('email')}}>
        </div>
        <div class="form-group">
          <label class="control-label">{{ __('Password') }}</label>
          <input class="form-control" type="password" id="password" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <div class="utility">
            <div class="animated-checkbox">
              <label>
                <input type="checkbox" name="remember"><span class="label-text">{{ __('Stay Signed in') }}</span>
              </label>
            </div>
            <p class="semibold-text mb-2"><a href="{{ route('password.request')}}" data-toggle="flip">{{ __('Forgot
                Password') }} ?</a></p>
          </div>
        </div>
        <div class="form-group btn-container">
          <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>{{ __('SIGN IN') }}</button>
        </div>
      </form>
    </div>
  </section>
  <!-- Essential javascripts for application to work-->
  <script src="{{asset('assets')}}/js/jquery-3.3.1.min.js"></script>
  <script src="{{asset('assets')}}/js/popper.min.js"></script>
  <script src="{{asset('assets')}}/js/bootstrap.min.js"></script>
  <script src="{{asset('assets')}}/js/main.js"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="{{asset('assets')}}/js/plugins/pace.min.js"></script>
</body>

</html>