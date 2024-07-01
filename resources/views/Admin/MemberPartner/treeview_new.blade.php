<div class="relative mt-20">
    <a class="btnstyle1 btnstyle1-success h-31 save-tree-partner" data-action="{{route('admin.partner.update-tree-partner')}}" style="z-index: 999"> <i class="fa fa-cog pointer-events-none"></i> 설졍값 저장</a>
    
    <input type="hidden" name="action-get-list-partner" value="{{ route('admin.partner.get-data-partner') }}">
    
    <div class="container">
        <div class="wrapper mt-20">
            <ul id="left-tree"></ul>

            <input type="hidden" name="data_show">
        </div>
    </div>
</div>