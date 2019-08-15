@extends('layouts.app')

@section('content')
<div class="card">
        <div class="card-header">My Profile</div>
        @include('partials.errors')
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif  
            <form action="{{route('users.update-profile')}}" method="POST">
            @csrf
            @method('PUT')
           <div class="form-group">
               <label for="name">Name</label>
               <input type="text" name="name" id="name" class="form-control" value="{{$user->name}}">
           </div>

           <div class="form-group">
               <label for="about">About Me</label>
               <textarea class="form-control" name="about" id="about" cols="5" rows="5">{{$user->about}}</textarea>
           </div>
           <button type="submit" class="btn btn-success">Update-profile</button>
            </form>
        </div>
@endsection
