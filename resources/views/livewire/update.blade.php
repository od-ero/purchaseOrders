<!-- Modal -->
<div wire:ignore.self class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
       <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="exampleModalLabel">Update Users Detals</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="name" wire:model="name" type="text" placeholder="Enter user name" />
                                <label for="inputPassword">Name</label>
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <input type="hidden" wire:model="user_id">
                           
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputEmail" wire:model="email" type="email" placeholder="Enter user email"   />
                                <label for="inputPassword">Email</label>
                                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputPhone" wire:model="phone" type="tel" placeholder="Enter user phone No"  required />
                                <label for="inputPhone">Phone Number</label>
                                @error('phone') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-floating mb-3 mb-md-0">
                                <input class="form-control" id="inputPhone" wire:model="role_id" type="text" placeholder="Select user role"  required />
                                <label for="inputPhone">Role</label>
                                @error('role_id') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="cancel()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" wire:click.prevent="update()" class="btn btn-primary" data-dismiss="modal">Save changes</button>
            </div>
       </div>
    </div>
</div>

