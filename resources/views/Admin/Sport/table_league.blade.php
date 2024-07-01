<table class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th style="width: 18.5%">리그아이디</th>
            <th style="width: 18.5%">리그네임</th>
            <th style="width: 18.5%">지역</th>
            <th style="width: 18.5%">스포츠</th>
            <th style="width: 12%">노출</th>
            <th style="width: 9%">이미지</th>
            <th style="width: 5%">배팅수</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td><input class="w-full h-28 text-center" type="text" name="idx[]" value="{{ $item->idx }}" readonly></td>
                <td><input class="w-full h-28 text-center" type="text" name="name[]" value="{{ $item->name }}"></td>
                <td><input class="w-full h-28 text-center" type="text" name="location_name[]" value="{{ $item->location->location_name }}" readonly></td>
                <td><input class="w-full h-28 text-center" type="text" name="kind[]" value="{{ $item->kind }}" readonly></td>
                <td>
                    <div class="w-116 m-auto">
                        <x-common.toggle_switch_button
                            isCheck="{{ $item->show }}"
                            id="show-{{$item->idx}}"
                            name="show"
                            urlAction="{{route('admin.sport.toggle-show', ['type' => $type, 'idx' => $item->idx])}}"
                            size="normal"
                        />
                    </div>
                </td>
                <td>
                    <div class="flex items-center" style="position: relative;">
                        <x-common.upload_image
                            index="{{ $item->idx }}"
                            imageUrl="{{ $item->mark }}"
                            name="mark[]"
                            width="78"
                            height="78"
                        />
                        <a href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 m-r-5 fileupload-exists remove-image" style="position: absolute; right: -3px;" data-id="{{ $item->idx }}" data-dismiss="fileupload"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </td>
                <td>0</td>
            </tr>
        @endforeach
    </tbody>
</table>