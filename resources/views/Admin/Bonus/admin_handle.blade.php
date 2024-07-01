<form action="{{ route('admin.money-info.index', ['type' => 'withdraw']) }}" method="GET">
    <div class="panel-heading-btn-page">
        <div class="btn-group">
            <input type="text" placeholder="회원아이디"
                class="form-control p-5 m-0 search-input-box height-33 text-white" />
        </div>
        <div class="btn-group">
            <input type="text" placeholder="처리내용"
                class="form-control p-5 m-0 search-input-box height-33 text-white width-300" />
        </div>
        <div class="btn-group">
            <input type="text" placeholder="보너스금액"
                class="form-control p-5 m-0 search-input-box height-33 text-white" inputmode="decimal" />
        </div>
        <div class="btn-group">
            <button type="button" class="btnstyle1 btnstyle1-success btnstyle1-sm height-31">
                보너스처리
            </button>
        </div>
    </div>
</form>
