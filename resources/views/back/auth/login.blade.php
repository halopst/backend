@extends('back.layout.template-nosidebar')
@section('content')

<div class="card">
    <div class="card-body">
      <!-- Logo -->
      <div class="app-brand justify-content-center mt-2">
        <a href="/" class="app-brand-link gap-2">
          <img src="{{ asset('img/logo/halopst.png')}}"  />
                    
          <span class="app-brand-text demo text-body fw-bolder"></span>
        </a>
      </div>
      <!-- /Logo -->
      {{-- dasdasda{{ session('error')}} - - - -dasdasa --}}
      @if(!empty($error))
        <div class="alert alert-warning" role="alert">{{$error}}</div>
      @endif

       <!-- Display Validation Errors -->
       @if ($errors->any())
       <div class="alert alert-danger">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
       @endif

      <form action="{{ url('/login/external-user') }}" class="mb-3" action="index.html" method="POST">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email or Username</label>
          <input
            type="text"
            class="form-control"
            id="email"
            name="email"
            placeholder="Enter your email or username"
            autofocus
          />
        </div>
        <div class="mb-3 form-password-toggle">
          <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
            <a href="#">
              <small>Lupa Password?</small>
            </a>
          </div>
          <div class="input-group input-group-merge">
            <input
              type="password"
              id="password"
              class="form-control"
              name="password"
              placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
              aria-describedby="password"
              minlength="6"
              maxlength="10"
            />
            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
          </div>
          <small id="passwordHelp" class="form-text text-muted"></small>
        </div>
        <div class="mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember-me" />
            <label class="form-check-label" for="remember-me"> Remember Me </label>
          </div>
        </div>
        <div class="mb-3">
          <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
        </div>
      </form>

      <div class="mb-3">
        <a type="button" class="btn btn-warning d-grid w-100" href="login/keycloak"
            >
            Login SSO BPS
        </a>    
    </div>

      {{-- <p class="text-center">
        <span>New on our platform?</span>
        <a href="auth-register-basic.html">
          <span>Create an account</span>
        </a>
      </p> --}}
    </div>
  </div>

  <script>
    $(document).ready(function() {
      $('#password').on('input', function() {
        var password = $(this).val();
        var message = '';

        if (password.length < 6 || password.length > 10) {
          message = 'Password harus antara 6 hingga 8 karakter.';
        }

        $('#passwordHelp').text(message);
      });
    });
  </script>
    @endsection

    
