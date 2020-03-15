@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-start">
     <a href="{{route('posts.create')}}" class="btn btn-success mb-3">Add Posts</a>
</div>
<div class="card card-default">

    <div class="card-header">
        Posts
    </div>

    <div class="card-body">
       @if ($posts->count()>0)
       <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th></th>
                <th></th>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>
                        <img src="{{asset('/storage/'.$post->image)}}" alt="" width="100px" height="60px">
                        {{-- <img src="storage/{{($post->image)}}"  alt="" width="60px" height="60px"> --}}
                        {{--  Not Working as per tutorials <img src="{{($post->image)}}"  alt="" width="60px" height="60px"> --}}
                    </td>
                    <td>
                        {{$post->title}}
                    </td>
                    <td>
                     <a href="{{route('categories.edit', $post->category->id)}}"> {{$post->category->name}}</a>
                    
                    </td>
                    @if ($post->trashed())
                         <td>
                             <form action="{{route('restore-posts', $post->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                    <button type="submit" class="btn btn-info btn-sm">Restore</button>
                             </form>
                         </td>
                    @else
                        <td>
                         <a href="{{route('posts.edit', $post->id)}}" class="btn btn-info btn-sm">Edit</a>
                         </td>

                    @endif
                    <td>
                       <form action="{{route('posts.destroy', $post->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                        {{ $post->trashed() ? 'Delete' : 'Trash'}}    
                        </button>
                       </form>
                    </td>
                </tr>              
            @endforeach   
            
            </tbody>
        </table>
         @else
         <h3 class="text-center">No Posts Yet</h3>
       @endif
    </div>
</div>

@endsection