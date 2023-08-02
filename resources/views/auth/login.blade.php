@extends('layouts.app')
@section('content')
<section >
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-3 pb-2 pb-md-0 mb-md-4">Login Form</h3>
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif
                <form  method="POST" action="{{route('login')}}">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-2">
                        <label class="form-label" for="email">Email Address</label>
                        <input value="{{ old('email') }}"  type="email" name="email"  id="email" class="@error('email') is-invalid @enderror form-control form-control-lg" />
                    </div>
                  
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input value="{{ old('password') }}"  type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control form-control-lg" />
                    </div>
                  
                    <!-- 2 column grid layout for inline styling -->
                    <div class="row mb-3">                  
                      <div class="col">
                        <!-- Simple link -->
                        <a href="{{ route('showForgotForm') }}">Forgot password?</a>
                      </div>
                    </div>
                  
                    <!-- Submit button -->
                    <div  class="d-grid gap-2 col-6 mx-auto mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">Sign in</button>
                    </div>
                    
                  
                    <!-- Register buttons -->
                    <div class="text-center">
                      <p>Not a member? <a href="{{ route('showRegistrationForm') }}">Register</a></p>
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection