{{-- <div class="panel-heading p-b-13 el-row breadcrumbs">
    <div class="panel-heading-btn">
    </div>
    @if(isset($breadcrumbs))
    @foreach($breadcrumbs as $index => $breadcrumb)
    <h4 class="panel-title m-5 text-light">
        <strong><i class=""></i>
            PARTNER :: @if(isset($breadcrumb['href'])) <a href="{{$breadcrumb['href']}}"> @endif{{$breadcrumb['title']}}</a>
        </strong>
    </h4>
    @endforeach
    @else
    <h4 class="panel-title m-5 text-light">
        <strong><i class=""></i>
            PARTNER :: {{$title}}</a>
        </strong>
    @endif
</div> --}}

<x-common.panel_heading page="PARTNER" title="파트너" form="Admin.MemberPartner.form_search"/>