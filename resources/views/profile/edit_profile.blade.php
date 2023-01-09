<div id="EditProfileModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" aria-label="Close" class="close outline-none" data-dismiss="modal">×</button>
            </div>
            <form method="POST" id="editProfileForm" enctype="multipart/form-data">
                {{-- <div class="alert alert-info">
                    Note: This is just UI. you need to develop Backend for update
                </div> --}}
                <div class="modal-body">
                    {{-- <div class="alert alert-danger d-none" id="editProfileValidationErrorsBox"></div> --}}
                    <div id="err"></div>
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>Name:</label><span class="required">*</span>
                                <input type="text" id="name" class="form-control" required autofocus
                                    tabindex="1" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Email:</label><span class="required">*</span>
                                <input type="text" readonly id="email" class="form-control" required tabindex="3" value="{{ Auth::user()->email }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Nik:</label><span class="required">*</span>
                                <input type="text" id="nik" class="form-control" required tabindex="3" value="{{ Auth::user()->nik }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Umur:</label><span class="required">*</span>
                                <input type="text" id="umur" class="form-control" required tabindex="3" value="{{ Auth::user()->umur }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>No Telephone:</label><span class="required">*</span>
                                <input type="text" id="telp" class="form-control" required tabindex="3" value="{{ Auth::user()->telp }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label>Alamat:</label><span class="required">*</span>
                                <textarea class="form-control" id="alamat" cols="30" rows="10">{{ Auth::user()->alamat }}</textarea>
                            </div>
                        </div>
                    </form>
                    <div class="text-right">
                        <button class="btn btn-primary edit" data-id="{{ Auth::user()->id }}" id="btnPrEditSave"></button>
                        <button type="button" class="btn btn-light ml-1 edit-cancel-margin margin-left-5"
                                data-dismiss="modal">Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

