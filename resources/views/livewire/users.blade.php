<div>
<script
  src="https://code.jquery.com/jquery-3.7.1.js"
  integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
  crossorigin="anonymous"></script>
   
    
    @if (session()->has('message'))
        <div class="alert alert-success" style="margin-top:30px;">x
          {{ session('message') }}
        </div>
    @endif

    <div class="card-body">
    @include('livewire.update')
        <table id="datatablesSimple">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        </thead>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($users as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->phone }}</td>
                <td>{{ $value->role_name }}</td>
                <td>

                
                <!-- <div class="btn-group">
                    <a class="btn btn-info text-white link_no_underline" href="#">View</a>
                        <button type="button" class="btn btn-info dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a data-id="' . $row->id . '" class="editanydesk link_no_underline dropdown-item" href="#">Edit</a>
                            <a data-id="' . $row->id . '" class="deactivateanydesk link_no_underline dropdown-item" href="#">Delete</a>
                        </div>
                    </div> -->
                    <div class="btn-group">
                    <a class="btn btn-info btn-sm text-white link_no_underline" href="#">View</a>
                        <button type="button" class="btn btn-outline-info dropdown-toggle dropdown-toggle-split btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a data-toggle="modal" data-target="#updateModal" wire:click="edit({{ $value->id }})" class="editanydesk link_no_underline dropdown-item " href="#">Edit</a>
                            <a data-toggle="modal" data-target="#delete_user_{{ $value->id }}" class="deactivateanydesk link_no_underline dropdown-item" href="#">Delete</a>
                        </div>
                    </div>




                </td>
            </tr>
            <div class="modal fade" id="delete_user_{{ $value->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-center" id="exampleModalLabel">Delete user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete {{$value->name}}?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button wire:click="delete({{ $value->id }})" type="button" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>
            @endforeach
        </tbody>
        </table>
     </div>
    
</div>