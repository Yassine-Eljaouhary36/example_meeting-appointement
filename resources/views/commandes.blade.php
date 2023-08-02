@extends('layouts.app')
@section('content')
<div class="container my-5">
   @if ($message = Session::get('success'))
   <div class="alert alert-success alert-block">	
         <strong>{{ $message }}</strong>
   </div>
   @endif
   @if ($message = Session::get('failure'))
   <div class="alert alert-danger alert-block">	
         <strong>{{ $message }}</strong>
   </div>
   @endif
   <div class="card">
      <div class="card-body p-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Reserved Date</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse($meetings  as $index => $meeting)
                <tr>
                    <th scope="row"> {{$loop->index + 1}}</th>
                    <td>
                        <?php
                            $dateTime= \Carbon\Carbon::parse("2023-08-02T09:30:00.000Z");
                        ?>
                        {{$dateTime->format('Y/m/d H:i:s')}}
                    </td>
                    <td>{{config('meetConfig.MeetingPrice')}} USD</td>
                    <td>
                        <form action="{{ route('cart.destroy', $index) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="text-md fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <p>
                        No meetings
                    </p>
                </tr>
                @endforelse
            </tbody>
          </table>
      </div>
   </div>
</div>
@endsection