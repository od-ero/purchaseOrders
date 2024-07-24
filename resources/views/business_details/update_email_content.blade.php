<div class="modal fade" id="update_email_content_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Email Content</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="update_email_content_form">
                @csrf
                
                <div class="form-floating my-3 mb-md-0">
                    <input class="form-control" id="email_subject" type="text" name="email_subject" value="{{$email_content['email_subject']}}" placeholder="Batch Name" />
                    <label for="email_subject">Subject<strong class="text-danger">*</strong></label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="form-floating my-3 mb-md-0">
                    <textarea id="email_body" name="email_body" class="form-control" style="height: 100px">{{$email_content['email_body']}}</textarea>
                    <label for="email_body">Body</label>
                </div>
                <div class="form-floating my-3 mb-md-0">
                    <input class="form-control" id="email_cc" type="email" name="email_cc" value="{{$email_content['email_cc']}}" placeholder="Default CC" />
                    <label for="email_cc">Default CC</label>
                    @if ($errors->has('batch_name'))
                        <div class="text-danger mt-2">
                            {{ $errors->first('batch_name') }}
                        </div>
                    @endif
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" i class="btn btn-primary">Save</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>