@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="container-fluid">
            <div class="row">
               <div class="col-md-4">
                  <div class="user-wrapper">
                     <ul class="users" style='text-align: center;'>
                        @foreach($users as $user)
                          <li class="user" id="{{ $user->id }}">
                             <div class="media-body">
                                <p class="name">{{ $user->name }}</p>
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
    </div>
@endsection

