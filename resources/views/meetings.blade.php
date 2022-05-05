@extends('layouts.app')
@section('content')
<div class="container mt-5">
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-block">	
         <strong>{{ $message }}</strong>
   </div>
   @endif
   @if ($errors->any())
   <div class="alert alert-danger">	
      Please check the form below for errors
   </div>
   @endif
   <div class="card">
      <div class="card-body p-5">
         <form action="{{route('store')}}" method="post" onsubmit="event.preventDefault();">
            @csrf
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