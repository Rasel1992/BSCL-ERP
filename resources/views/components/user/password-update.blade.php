<div id="change-password-modal" class="modal fade" aria-hidden="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form method="POST" accept-charset="UTF-8" id="change-password-form" data-toggle="validator" novalidate="true">
                @csrf
                @method('put')
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    Form
                </div>
                <div class="modal-body">
                    <div class="form-group @error('password') has-error @enderror">
                        <label for="password">New password*</label>
                        <div class="row">
                            <div class="col-md-6 nopadding-right">
                                <input class="form-control" placeholder="Password" data-minlength="8" required="" name="password" type="password" value="">
                            </div>
                            <div class="col-md-6 nopadding-left">
                                <input class="form-control" placeholder="Confirm password" data-match="#password" required="" name="password_confirmation" type="password" value="">
                            </div>
                        </div>
                        @error('password')
                        <span class="help-block">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="button save" type="submit">Update</button>
                </div>
            </form>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>
