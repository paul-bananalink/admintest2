<form action="#" method="POST" id="cash_payment_recovery_form">
    <div class="panel-heading-btn-page">
        <div class="btn-group">
            <input placeholder="회원아이디" type="text"
                class="form-control input-sm w-80 search-input-box h-33 p-l-5 text-white" name="mID">
        </div>
        <div class="btn-group">
            <input placeholder="처리내용" type="text"
                class="form-control input-sm w-250 search-input-box h-33 p-l-5 text-white" name="miDescription"
                id="miDescription">
        </div>
        <div class="btn-group w-100 mr-4">
            <select id="miWallet" name="miWallet" class="form-control">
                {{-- <option value="sports">스포츠캐쉬</option> --}}
                <option value="casino_slot">카지노캐쉬</option>
            </select>
        </div>
        <div class="btn-group">
            <input placeholder="처리내용" type="number"
                class="form-control input-sm w-250 search-input-box h-33 p-l-5 text-white" name="miBankMoney"
                id="miBankMoney">
        </div>
        <div class="btn-group">
            <button type="submit" name="filter" value="temp4 director" class="btnstyle1 btnstyle1-success h-31"
                data-url="">캐쉬처리</button>
        </div>
    </div>
</form>
@section('custom-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('cash_payment_recovery_form');
            var mIDInput = document.querySelector('input[name="mID"]');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                var mID = mIDInput.value.trim();
                if (mID !== '') {
                    var actionUrl =
                        "{{ route('admin.money-info.direct-recharge-or-withdraw', ['mID' => ':mID']) }}";
                    actionUrl = actionUrl.replace(':mID', mID);
                }
                miWallet = $('#miWallet').val()
                miDescription = $('#miDescription').val()
                miBankMoney = $('#miBankMoney').val()
                miType = miBankMoney >= 0 ? 'AD' : 'AW'

                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        miWallet: miWallet,
                        miDescription: miDescription,
                        miBankMoney: miBankMoney,
                        miType: miType
                    },
                    success: function(html) {
                        console.log(html);
                        return false;
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
