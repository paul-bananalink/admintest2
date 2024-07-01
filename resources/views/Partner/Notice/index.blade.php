@extends('Partner.page')

@section('content-child')
    <div class="row">
        <div class="col-md-12">
            <div class="box mb-0">
                <div class="box-content pt-0">
                    @if (session('success'))
                        <div class="alert alert-success">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Success!</strong> {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <button class="close" data-dismiss="alert">×</button>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                    @endif

                    <div>
                        @include('components.common.panel_heading', [
                            'icon' => 'fa fa-arrow-down',
                            'page' => 'PARTNER NOTICE',
                            'title' => '파트너공지사항 관리',
                        ])
                        <div class="box-content-detail bg-black-darker">
                            <table class="table table-bordered table-td-valign-middle text-center text-white no-bg">
                                <thead>
                                    <th class="w-100">No.</th>
                                    <th class="text-left">공지안내 구분</th>
                                    <th class="text-left" style="width: 240px">이미지</th>
                                    <th class="text-center" style="width: 120px">공지사항 내용</th>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $notice)
                                        <tr>
                                            <td>{{ ++$index }}</td>
                                            <td class="text-left">{{ $notice->ntTitle }}</td>
                                            
                                            <td class="text-left">
                                                @if ($notice->ntLogo)
                                                    <img src="{{ getImageUrl($notice->ntLogo) }}" alt="Image"
                                                        style="max-width: 100px; height: auto;">
                                                @else
                                                    No Image
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                {{-- <div class="content-scroll w-700 m-h-350">
                                                    {!! $notice->ntContent !!}
                                                </div> --}}
                                                <a href="#" class="btnstyle1 btnstyle1-info h-31 text-white px-8 show-content"
                                                    data-modal="modalShowContentNoticePartner"
                                                    data-action="{{ route('partner.notice.ajax-show-content', ['ntNo' => $notice->ntNo]) }}"
                                                >
                                                    <i class="fa fa-bar-chart-o text-gray2 f-s-20 m-t-2 pointer-events-none" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                @if ($data)
                    <div class="text-center">
                        {{ $data->appends(request()->query())->links('Admin.Common.pagination') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('custom-css')
    @vite(['resources/vite/css/page-money-info/money_info.css'])
@endsection

@section('custom-js')
    @vite(['resources/vite/js/pusher/money_info/money_info.js'])

    <script>
        $("body").on("click", ".show-content", (e) => {
            e.preventDefault();
            let modal = '#' + $(e.currentTarget).data('modal');
            let action = $(e.currentTarget).data('action');

            $(modal + " .content_show").html('');

            $.ajax({
                url: action,
                type: "get",
                data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    $(modal + " .content_show").html(response);
                    $(modal).modal("show");
                },
                error: function (xhr, textStatus, errorThrown) {},
            });
        });
    </script>
    
@endsection
