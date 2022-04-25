@extends('layouts.app')
@section('content')
<div class="container-fluid">
   <div class="row">
     <div class="col-md-4">
        <div class="user-wrapper">
           <ul class="users">
             @foreach($groupALL as $user)
               <input type="hidden" id='i' value='{{$user->id}}'>
                  <li class="user" id="{{ $user->id }}">
                   <div class="media">
                     <div class="media-body">
                        <p class="name">{{ $user->name }}</p>
                        <p class="name">{{ $user->code }}</p>
                     </div>
                   </div>
                  </li>
              @endforeach
           </ul>
        </div>
     </div>
     <div class="col-md-8" id="messages">
     </div>
   </div>
</div>
@endsection
