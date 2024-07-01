@extends('Admin.PageSetting.manager_banner.page_manager_banner')

@section('content-child-child-child')
<form action="{{route('admin.page-setting.manager-banner.update-logo')}}"  method="POST">
   @csrf
   <div class="row">
      <div class="col-lg-3 row">
         <label class="col-lg-2 control-label">로고1</label>
         <div class="col-lg-10 controls">
            @include('Admin.PageSetting.manager_banner.group_image_page_logo', ['type' => 'siLogo1', 'site_info' => $site_info])
         </div>
      </div>
      <div class="col-lg-3 row">
         <label class="col-lg-2 control-label">로고2</label>
         <div class="col-lg-10 controls">
            @include('Admin.PageSetting.manager_banner.group_image_page_logo', ['type' => 'siLogo2', 'site_info' => $site_info])
         </div>
      </div>
      <div class="col-lg-3 row">
         <label class="col-lg-2 control-label">로고3</label>
         <div class="col-lg-10 controls">
            @include('Admin.PageSetting.manager_banner.group_image_page_logo', ['type' => 'siLogo3', 'site_info' => $site_info])
         </div>
      </div>
      <div class="col-lg-3 row">
         <label class="col-lg-2 control-label">파비콘</label>
         <div class="col-lg-10 controls">
            @include('Admin.PageSetting.manager_banner.group_image_page_logo', ['type' => 'siLogoFavicon', 'site_info' => $site_info])
         </div>
      </div>
   </div>

   <p class="text-center m-t">
      <button type="submit" class="btn btn-primary">저장</button>
   </p>
</form>
@endsection

@section('custom-css')
    @vite([
        'resources/lib/bootstrap/bootstrap-fileupload.css'
    ])
@endsection

@section('custom-js')
   @vite([
      'resources/lib/bootstrap/bootstrap-fileupload.min.js',
      'resources/vite/js/page_setting/manager_banner.js',
   ])
@endsection
