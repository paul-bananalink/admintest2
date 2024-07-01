<div class="banner-option">
    
</div>


<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3 class="cst_h3"><i class="fa fa-file"></i>배너관리</h3>
                <div class="box-tool">

                    <a href="{{route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_LOGO])}}"
                    @class(['btn btn-gray', 'active-btn' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_LOGO])])
                    >
                        로고
                    </a>
                
                    <a href="{{route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_CENTER])}}"
                    @class(['btn btn-gray', 'active-btn' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_CENTER])])
                    >
                        메인중앙
                    </a><!-- manager banner -->
                
                    <a href="{{route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_CENTER_BELOW])}}"
                    @class(['btn btn-gray', 'active-btn' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_CENTER_BELOW])])
                    >
                        메인하단
                    </a><!-- Withdraw -->
                
                    <a href="{{route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_RIGHT])}}"
                    @class(['btn btn-gray', 'active-btn' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_RIGHT])])
                    >
                        우측
                    </a> <!-- Withdraw -->
                
                    <a href="{{route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_LEFT])}}"
                    @class(['btn btn-gray', 'active-btn' => url()->current() == route('admin.page-setting.manager-banner.index', ['type' => \App\Models\Banner::TYPE_LEFT])])
                    >
                        좌측
                    </a>
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                @yield('content-child-child-child')
            </div>
        </div>
    </div>
</div>
