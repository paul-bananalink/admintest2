<!-- BEGIN Breadcrumb -->
<div class="panel-heading p-b-13 el-row breadcrumbs">
    <div class="panel-heading-btn">
    </div>
    @if(isset($breadcrumbs))
    @foreach($breadcrumbs as $index => $breadcrumb)
    <h4 class="panel-title m-5 text-light">
        <strong><i class=""></i>
            SETTLEMENT :: @if(isset($breadcrumb['href'])) <a href="{{$breadcrumb['href']}}"> @endif{{$breadcrumb['title']}}</a>
        </strong>
    </h4>
    @endforeach
    @else
    <h4 class="panel-title m-5 text-light">
        <strong><i class=""></i>
            SETTLEMENT :: {{$title}}</a>
        </strong>
    @endif
</div>
