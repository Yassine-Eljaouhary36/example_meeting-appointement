@extends('layouts.app')
@section('content')
<section >
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-3 pb-2 pb-md-0 mb-md-4">Reset Password</h3>
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
                <form  method="POST" action="{{route('resePassword')}}">
                    @csrf
                    <div class="row">
                          <input  value="{{ $token ?? '' }}"  type="hidden" name="token">
                    </div>
                  
                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password">Password</label>
                        <input value="{{ old('password') }}"  type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control form-control-lg" />
                    </div>
                  
                    <div class="form-outline mb-4">
                        <label class="form-label" for="password_confirmation">Confirm password</label>
                        <input value="{{ old('password_confirmation') }}"  type="password" name="password_confirmation" id="password_confirmation" class="@error('password_confirmation') is-invalid @enderror form-control form-control-lg" />
                        @if ($errors->has('password_confirmation'))<div class="text-danger"> {{ $errors->first('password_confirmation') }}</div>@endif
                    </div>

                  
                    <!-- Submit button -->
                    <div  class="d-grid gap-2 col-6 mx-auto mb-4">
                        <button type="submit" class="btn btn-primary btn-lg">Reset Password</button>
                    </div>
                    
                  
                    <!-- Register buttons -->
                    <div class="text-center">
                        <p>Already have an account? <a href="{{ route('showLoginForm') }}">Login</a></p>
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection