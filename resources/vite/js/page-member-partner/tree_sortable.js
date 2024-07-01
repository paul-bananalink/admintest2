import createToast from "../toast/script";

function initSortable() {
  let action = $("input[name=action-get-list-partner]").val();
  $.ajax({
    url: action,
    type: "get",
    data: {
      _token: $('meta[name="csrf-token"]').attr("content"),
    },
    success: function (response) {
      let dataLeft = response.data;
      const leftTreeId = "#left-tree";
      const leftSortable = new TreeSortable({
        treeSelector: leftTreeId,
      });
      const $leftTree = $(leftTreeId);
      const $content = dataLeft.map(leftSortable.createBranch);
      $leftTree.html($content);
      leftSortable.run();

      const delay = () => {
        return new Promise((resolve) => {
          setTimeout(() => {
            resolve();
          }, 1000);
        });
      };

      leftSortable.onSortCompleted(async (event, ui) => {
        await delay();
      });
    },
    error: function (xhr, textStatus, errorThrown) {},
  });
}

$(document).ready(function () {
  initSortable();
  $("body").on("click", ".save-tree-partner", (e) => {
    e.preventDefault();
    var branches = $(".tree-branch");
    var data = [];

    branches.each(function (index) {
      var id = $(this).data("id");
      var level = $(this).data("level");
      var parentId = $(this).data("parent");

      data.push({
        id: id,
        level: level,
        parent_id: parentId,
        position: index,
      });
    });

    var jsonData = JSON.stringify(data);

    $.ajax({
      url: $(e.target).data("action"),
      type: "post",
      data: {
        data: jsonData,
        _token: $('meta[name="csrf-token"]').attr("content"),
      },
      success: function (response) {
        if (response.status === "warning") {
          response.message.forEach(function (messages) {
            createToast(response.status, messages.message);
          });
        } else {
          createToast(response.status, response.message);
        }

        if (response.status) {
          initSortable();
        }
      },
      error: function (xhr, textStatus, errorThrown) {},
    });
  });

  $("body").on("click", ".toggle-parent", (e) => {
    e.preventDefault();

    let mID = $(e.target).data("mid");
    let dataShowInput = $('input[name="data_show"]');
    let currentValue = dataShowInput.val();

    let idsArray = currentValue ? JSON.parse(currentValue) : [];

    let index = idsArray.indexOf(mID);
    if (index > -1) {
      idsArray.splice(index, 1);
    } else {
      idsArray.push(mID);
    }

    dataShowInput.val(JSON.stringify(idsArray));

    $.ajax({
      url: $(e.target).data("route"),
      type: "get",
      data: {
        _token: $('meta[name="csrf-token"]').attr("content"),
        data_show: JSON.stringify(idsArray),
      },
      success: function (response) {
        let dataLeft = response.data;
        let listShow = response.show_list;

        dataShowInput.val(JSON.stringify(listShow));

        const leftTreeId = "#left-tree";
        const leftSortable = new TreeSortable({
          treeSelector: leftTreeId,
        });
        const $leftTree = $(leftTreeId);
        const $content = dataLeft.map(leftSortable.createBranch);
        $leftTree.html($content);
        leftSortable.run();

        const delay = () => {
          return new Promise((resolve) => {
            setTimeout(() => {
              resolve();
            }, 1000);
          });
        };

        leftSortable.onSortCompleted(async (event, ui) => {
          await delay();
        });
      },
      error: function (xhr, textStatus, errorThrown) {},
    });
  });
});
