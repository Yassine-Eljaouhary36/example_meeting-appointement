@extends('layouts.app')
@section('content')
<section >
    <div class="container py-5 h-100">
      <div class="row justify-content-center align-items-center h-100">
        <div class="col-12 col-lg-9 col-xl-7">
          <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
              <h3 class="mb-3 pb-2 pb-md-0 mb-md-4">Registration Form</h3>
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{Session::get('success')}}
                    </div>
                @endif
              <form method="POST" action="{{route('register')}}">
                 @csrf
  
                <div class="row">
                  <div class="col-md-6 mb-4">
  
                    <div class="form-outline">
                        <label class="form-label" for="first_name">First Name</label>
                        <input value="{{ old('first_name') }}"  type="text" name="first_name"  id="first_name" class="@error('first_name') is-invalid @enderror form-control form-control-lg" />
                        @if ($errors->has('first_name'))<div class="text-danger"> {{ $errors->first('first_name') }}</div>@endif
                    </div>
  
                  </div>
                  <div class="col-md-6 mb-4">
  
                    <div class="form-outline">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input value="{{ old('last_name') }}"  type="text" name="last_name" id="last_name" class="@error('last_name') is-invalid @enderror form-control form-control-lg" />
                        @if ($errors->has('last_name'))<div class="text-danger"> {{ $errors->first('last_name') }}</div>@endif
                    </div>
  
                  </div>
                  
                </div>
  
                <div class="row">
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                          <label class="form-label" for="email">Email Address</label>
                          <input value="{{ old('email') }}"  type="email" name="email"  id="email" class="@error('email') is-invalid @enderror form-control form-control-lg" />
                          @if ($errors->has('email'))<div class="text-danger"> {{ $errors->first('email') }}</div>@endif
                      </div>
    
                    </div>
                    <div class="col-md-6 mb-4">
    
                      <div class="form-outline">
                          <label class="form-label" for="phone">Phone</label>
                          <input value="{{ old('phone') }}"  type="text" name="phone" id="phone" class="@error('phone') is-invalid @enderror form-control form-control-lg" />
                          @if ($errors->has('phone'))<div class="text-danger"> {{ $errors->first('phone') }}</div>@endif
                      </div>
    
                    </div>
                    
                  </div>
  
                <div class="row">
                    <div class="col-md-6 mb-4">
    
                        <div class="form-outline">
                            <label class="form-label" for="password">Password</label>
                            <input value="{{ old('password') }}"  type="password" name="password" id="password" class="@error('password') is-invalid @enderror form-control form-control-lg" />
                            @if ($errors->has('password'))<div class="text-danger"> {{ $errors->first('password') }}</div>@endif
                        </div>
      
                      </div>
                      <div class="col-md-6 mb-4">
    
                        <div class="form-outline">
                            <label class="form-label" for="password_confirmation">Confirm password</label>
                            <input value="{{ old('password_confirmation') }}"  type="password" name="password_confirmation" id="password_confirmation" class="@error('password_confirmation') is-invalid @enderror form-control form-control-lg" />
                            @if ($errors->has('password_confirmation'))<div class="text-danger"> {{ $errors->first('password_confirmation') }}</div>@endif
                        </div>
      
                      </div>
                </div>

                <div class="row">
                    <div class="col mb-1">
    
                        <div class="d-flex">
                            <span style="padding-right: 5px">Already have an account ?</span> 
                            <a style="text-decoration: underline;" class="text-primary" href="{{ route('showLoginForm') }}"> Login</a>
                        </div>

                    </div>
                </div>

            
                <div  class="d-grid gap-2 col-6 mx-auto my-2">
                  <button type="submit" class="btn btn-primary btn-lg">register</button>
                </div>
  
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection