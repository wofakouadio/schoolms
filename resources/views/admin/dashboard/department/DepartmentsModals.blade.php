{{--Create ne department--}}
<div class="modal fade" id="new-department-modal">
    <form action="{{route('new-department')}}" method="post" id="new-department-form">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Department</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
{{--                    @if ($errors->any())--}}
                        <div class="alert menu-alert">

                        </div>
{{--                    @endif--}}
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Name<span class="text-danger scale5 ms-2">*</span></label>
                        <input type="text" class="form-control solid" placeholder="Name" aria-label="name" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="text-mute text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-xl-12 mb-4">
                        <label  class="form-label font-w600">Description</label>
                        <textarea class="form-control solid" rows="5" aria-label="With textarea" name="description">{{old('description')}}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
