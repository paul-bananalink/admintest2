<!-- BEGIN Main Content -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-content">
                @foreach ($data as $item)
                    <ul class="tree">
                        @include('Admin.MemberPartner.child_view', ['item' => $item])
                    </ul>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- END Main Content -->
