let tbody = $('#tbody_open_game');
let modal = $('#modal_open_list_game');
let currentTitle = modal.find('.modal-title').html();
let modalTile = modal.find('.modal-title');

$('.btn-gp-name').on('click', (e) => {
    let el = $(e.currentTarget);
    tbody.html('');
    modalTile.html('데이터 로드 중'); // 데이터 로드 중 => loading data
    $('#modal_open_list_game').modal('show');
    handleAjax(el);
});

const createTr = (gameChild) => {
    let tr = $('<tr></tr>');
    $.each(gameChild, (index, game) => {
        tr.append($('<td></td>').html(game?.gName));
        tr.append($('<td></td>').html(createToggle(tbody.attr('url-action'), game)));
    });
    return $('<div></div>').append(tr).html();
}

const handleAjax = (el_clicked) => {
    $.post(el_clicked.attr('target-url'), {
        _token: $('meta[name="csrf-token"]').attr('content'),
    },
    function (data, textStatus, jqXHR) {
        modalTile.html(currentTitle);
        showData(data?.games);
    },
    'json'
    );
}

const showData = (arrData) => {
    $.each(arrData, (index, gameChild ) => {
        tbody.append(createTr(gameChild));
    });
}

const createToggle = (urlAction, game) => {
    return `<div class="flex-center">
        <label class="switch">
            <input
            class="btn-toggle"
            type="checkbox"
            url_action="${urlAction.replace('gNo', game.gNo)}"
            ${game.gStatus ? 'checked' : ''}>
            <span class="slider round"></span>
        </label>
    </div>`;
}
