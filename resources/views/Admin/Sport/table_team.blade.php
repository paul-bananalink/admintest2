<table class="table table-bordered cst-table-darkbrown">
    <thead>
        <tr>
            <th>스포츠</th>
            <th style="width: 30%">팀네임</th>
            <th style="width: 30%">팀지정네임</th>
            <th style="width: 220px">이미지</th>
            <th style="width: 80px">저장</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->sport->sports_name }}</td>
                <td>{{ $item->team_name }}</td>
                <td><input class="w-full h-28 text-center" type="text" name="team_name_kor_{{$item->idx}}" value="{{ $item->team_name_kor }}"></td>
                <td>
                    <div class="flex items-center" style="position: relative;">
                        <x-common.upload_image
                            index="{{ $item->idx }}"
                            imageUrl="{{ $item->team_logo }}"
                            name="team_logo_{{$item->idx}}"
                            width="78"
                            height="78"
                        />
                        <a href="#" class="btnstyle1 btnstyle1-danger h-31 px-8 m-r-5 fileupload-exists remove-image" style="position: absolute; right: 10px;" data-id="{{ $item->idx }}" data-dismiss="fileupload"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </div>
                </td>
                <td>
                    <a class="h-28 btnstyle1 mb-8 btnstyle1-info update-row" href="#" data-idx="{{ $item->idx }}" 
                    data-action="{{ route('admin.sport.update-row-table-team', ['idx' => $item->idx]) }}">저장</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>