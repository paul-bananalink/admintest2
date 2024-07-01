<div class="form-group">
    <label class="col-xs-3 col-lg-1 control-label">레벨발송 선택</label>
    <div class="col-sm-9 col-lg-11 controls">
        <select class="form-control" tabindex="1" name="level">
            <option value="">레벨선택</option>
            @for ($i = 1; $i <= 20; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
</div>