@extends('layouts.app')
@section('content')
   <meetings-manager :meetings="{{json_encode($meetings)}}"></meetings-manager>
@endsection