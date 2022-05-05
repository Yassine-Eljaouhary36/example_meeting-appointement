@extends('layouts.app')
@section('content')
<div class="container my-5">
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-block">	
         <strong>{{ $message }}</strong>
   </div>
   @endif
   @if ($errors->any())
   <div class="alert alert-danger">	
      @foreach ($errors->all() as $error)
         <strong>-</strong>{{ $error }}<br>
      @endforeach
   </div>
   @endif
   <div class="card">
      <div class="card-body p-5">
         <form action="{{route('store')}}" method="post" onsubmit="event.preventDefault();">
            @csrf
            <div class="row align-items-center mb-4">
               <div class="col-12">
                  <label class="form-label">First Name</label>
                  <input type="text" class="form-control" name="FirstName" value="{{ old('FirstName') }}" >
               </div>
               <div class="col-12">
                  <label class="form-label">Last Name</label>
                  <input type="text" class="form-control" name="LastName" value="{{ old('LastName') }}" >
               </div>
               <div class="col-12">
                  <label class="form-label">Email address</label>
                  <input type="text" class="form-control" name="email" value="{{ old('email') }}" >
               </div>
            </div>
            
            <meetings-manager :meetings="{{json_encode($meetings)}}"></meetings-manager>
            <div class="d-grid gap-1 col-6 mx-auto mt-4">
               <button type="submit" class="btn btn-outline-dark" onclick="submit()">
                  <strong>submit</strong>
               </button>
            </div>
         </form>
      </div>
   </div>
</div>
@endsection