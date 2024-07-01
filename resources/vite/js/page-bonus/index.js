import { fetchData } from "../functions.js";

$(document).ready(function () {
  $(document).on("click", ".open-modal-money-info", function (event) {
    let action = $(this).data("url");
    fetchData(action, "get").then((data) => {
      $("#myModalViewMoneyInfo #rechargeTable tbody").html(data);
    });
  });
});
