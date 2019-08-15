@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-start">
 <a href="{{route('tags.create')}}" class="btn btn-success mb-3">Add Tags</a>
</div>

    <div class="card card-default">    
        <div class="card-header">Tags</div>
        <div class="card-body">
            @if ($tags->count()>0)
            <table class="table">
                <thead>
                    <th>Name</th>    
                    <th>Post Count</th>
                    <th></th>
                </thead>    
                <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td>
                                {{$tag->name}}
                            </td>
                            <td>
                              {{ $tag->posts->count()}}
                              
                            </td>
                            <td>
                             <a href="{{route('tags.edit', $tag->id)}}" class="btn btn-info btn-sm">Edit</a>
                             <button class="btn btn-danger btn-sm" onclick="handleDelete({{$tag->id}})" >Delete</button>
                            </td>
                        </tr>

                    @endforeach   
                </tbody>                
            @else
                <h4 class="text-center">No Tags Yet</h4>
            @endif
            </table>   
            <form action="" method="POST" id="deleteTagForm">
                @csrf
                @method('DELETE')
                {{-- Modal for Delete Action --}}
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModallabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="deleteModal">Delete Tags</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Are you sure you want to delete this category?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Go back</button>
                          <button type="submit" class="btn btn-danger">Yes Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- Modal for Delete Action --}}

            </form>
         </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
       function handleDelete(id)
       {
        //  console.log('Deleting', id);
        var form=document.getElementById('deleteTagForm');
        form.action= '/tags/' +id;
        $('#deleteModal').modal('show');
       }
    </script>
@endsection
