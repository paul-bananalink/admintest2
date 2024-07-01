<div class="modal fade" id="modal-auto-reply" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-body">
                <div class="col-md-12 p-0 mb-4">
                    <select class="form-control width-full edit-level">
                        @foreach (range(1, 20) as $level)
                            <option value="{{ $level }}">
                                {{ $level }}레벨</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12 p-0 mb-4">
                    <input type="text" class="form-control width-full edit-link">
                </div>
                <div class="col-md-12 p-0 mb-4">
                    <textarea style="overflow-y: auto" class="width-full p-10 edit-desc js__editor" cols="20" rows="10"></textarea>
                </div>
            </div>
            <div class="text-center p-10">
                <button data-dismiss="modal" class="btnstyle1 height-30  btnstyle1-inverse2"
                    aria-hidden="true">Close</button>
                <button type="submit" class="btnstyle1 height-30  btnstyle1-success" id="btn-edit">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
