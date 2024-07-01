<form action="{{ route('admin.page-setting.display.store') }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="tools-bar mt-12 mb-12">
                    <div class="float-left">
                        <strong class="form-title"><i class="fa fa-cog"></i>디자인설정</strong>
                    </div>
                    <div class="float-right">
                        <button type="submit" class="btnstyle1 btnstyle1-inverse2 h-31">
                            저장
                        </button>
                    </div>
                </div>
                <div class="box-content">
                    <div class="col-md-12 panel panel-inverse bg-black-3 m-t-10 m-b-10 p-5 text-light">
                        <div class="pull-left m-t-10 text-left">
                            <div class="panel-title ml-12 text-light mb-12">
                                <strong class="form-title"><i class="fa fa-cog"></i> 상단 메뉴 설정</strong>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex">
                                @foreach (range(0, 7) as $i)
                                    <div class="text-light width-eight-item border-item">
                                        <select class="form-control mb-12" name="menu[{{ $i }}][key]"
                                            id="{{ $i }}" data-placeholder="Choose a Category"
                                            tabindex="1">
                                            @foreach (config('site_config.MENU_LIST') as $key => $value)
                                                <option @selected(!empty($data['menu']->dpData[$i]['key']) && $data['menu']->dpData[$i]['key'] == $key) value="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" class="form-control mr-2"
                                            name="menu[{{ $i }}][value]"
                                            value="{{ $data['menu']->dpData[$i]['value'] ?? '' }}" placeholder="문구" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 px-0">
                        <div class="d-flex">
                            <div class="bg-black-3 m-t-10 m-b-10 text-light mr-24 width-four-item">
                                <div class="m-t-10 mb-10 text-left">
                                    <div
                                        class="panel-title ml-12 text-light d-flex items-center justify-content-between">
                                        <strong class="form-title"><i class="fa fa-cog"></i> 모바일 바둑판 설정</strong>
                                        <button type="submit" id="add_mobile_icon"
                                            class="btnstyle1 btnstyle1-primary h-31 mr-12 ">
                                            <i class="fa fa-plus"></i>
                                            추가
                                        </button>
                                    </div>
                                </div>
                                <div class="mobile-icons-list">
                                    @php
                                        $mobileIcons = $data['mobile_icons']->dpData ?? [];
                                    @endphp
                                    @foreach ($mobileIcons as $i => $icon)
                                        @include(
                                            'Admin.PageSetting.Display.form_mobile_icon',
                                            compact('icon', 'i'))
                                    @endforeach
                                </div>
                            </div>
                            <div class="bg-black-3 m-t-10 m-b-10 text-light mr-24 width-four-item">
                                <div class="m-t-10  text-left">
                                    <div
                                        class="panel-title ml-12 mb-12 text-light d-flex items-center justify-content-between">
                                        <strong class="form-title"><i class="fa fa-cog"></i> 배너 설정</strong>
                                        <button id="add_banner" type="submit"
                                            class="btnstyle1 btnstyle1-primary h-31 mr-12 ">
                                            <i class="fa fa-plus"></i>
                                            추가
                                        </button>
                                    </div>
                                    <div class="banner-list">
                                        @php
                                            $banners = $data['banner']->dpData ?? [];
                                        @endphp
                                        @foreach ($banners as $i => $banner)
                                            @include(
                                                'Admin.PageSetting.Display.form_banner',
                                                compact('banner', 'i'))
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="bg-black-3 m-t-10 m-b-10 text-light mr-24 width-four-item">
                                <div class="m-t-10 text-left">
                                    <div class="panel-title ml-12  text-light">
                                        <strong class="form-title"><i class="fa fa-cog"></i> 좌촉 바둑판 설정</strong>
                                    </div>
                                    @foreach (collect(range(0, 20))->chunk(3) as $chunk)
                                        <div class="col-md-12 d-flex">
                                            @foreach ($chunk as $i)
                                                <div class="col-md-4 mb-12 pr-4 pl-4 border-item mr-3 ml-3">
                                                    <select class="form-control mb-12"
                                                        name="left_menu[{{ $i }}][status]"
                                                        data-placeholder="Choose a Category" tabindex="1">
                                                        @foreach (config('site_config.MENU_LIST') as $key => $value)
                                                            <option @selected($data['left_menu']?->dpData[$i]['status'] == $key)
                                                                value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <input type="text" class="form-control mr-2"
                                                        name="left_menu[{{ $i }}][value]"
                                                        value="{{ $data['left_menu']->dpData[$i]['value'] ?? '' }}"
                                                        placeholder="문구" />
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>
