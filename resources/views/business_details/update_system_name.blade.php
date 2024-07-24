<div class="modal fade" id="update_system_name_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit System Name</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="update_system_name_form">
                    @csrf
                    <label for="login_password">System Business Name</label>
                    <div class="form-floating login_form_password my-3">
                        <input class="form-control" id="system_name" type="text" name="system_name" value="{{session('system_name')}}" />
                       
                        @if ($errors->has('password'))
                            <div class="text-danger mt-2">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                   
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="update_system_name_modal_button" class="btn btn-primary">Save</button>
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>