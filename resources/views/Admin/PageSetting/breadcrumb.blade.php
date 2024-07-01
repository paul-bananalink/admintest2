<!-- BEGIN Breadcrumb -->
<div id="breadcrumbs">
    <ul class="breadcrumb cst_breadcrumb">
        <div class="row">
            <div class="col-md-3 p-5-10">
                <i class="fa fa-home"></i>
                <a href="{{route('admin.dashboard.index')}}">Home</a>
                <span class="divider"><i class="fa fa-angle-right"></i></span>
                <span class="active">{{$title}}</span>
            </div>
            <div class="col-md-9 text-right right-button">
                @include('Admin.PageSetting.action_box')
            </div>
        </div>
    </ul>
</div>
<!-- END Breadcrumb -->
