$(document).ready(function () {
  "use strict";

  window.viewButton = function (clientID) {
    //console.log("viewButton");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/list_client.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        $("#" + clientID).html(xmlhttp.responseText);
      }
    };
    xmlhttp.send("clientID=" + clientID);
  };

  window.closeButton = function (clientID) {
    //console.log("closeButton");

    var clientName = $("#clientName" + clientID).val();
    var viewClientButton =
      '<button class="viewButton" onclick="viewButton(this.value);"';
    viewClientButton += 'value="' + clientID + '">Visualizar cliente</button>';
    $("#" + clientID).html(clientName + viewClientButton);
  };

  window.monthlyButton = function (clientID) {
    //console.log("monthlyButton");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/monthly_client.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        $("#" + clientID).html(xmlhttp.responseText);
      }
    };
    xmlhttp.send("clientID=" + clientID);
  };

  window.payButton = function (monthlyID, clientID, clientName) {
    //console.log("payButton");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/monthly_payment.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        $("#" + monthlyID).html(xmlhttp.responseText);
        var clientStatus = $("#ajaxDatePay").val();
        document.getElementById(clientID).className = clientStatus;
      }
    };
    xmlhttp.send("monthlyID=" + monthlyID + "&clientName=" + clientName);
  };

  window.deleteButton = function (clientID) {
    //console.log("deleteButton");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/delete_client.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      console.log(
        "state: " + xmlhttp.readyState + " - status: " + xmlhttp.status
      );
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var messageServer = xmlhttp.responseText;
        console.log("Server msg: " + messageServer);
        if (messageServer == "") {
          alert("Cliente removido com sucesso!");
          $("#" + clientID).remove();
        } else {
          alert(messageServer);
        }
      }
    };
    xmlhttp.send("clientID=" + clientID);
  };

  window.updateButton = function (formID) {
    //console.log("updateButton");
    $("#form" + formID).submit();
  };

  window.searchClient = function () {
    //console.log("search client");
    $("#findClient").submit();
  };

  window.updateMonthlyView = function () {
    //console.log("updateMonthlyView");
    var form = document.getElementById("formMonthly");

    form.style.display = "block";

    $("#monthlyDatePay").mask("99/99/9999");
    $("#monthlyValue").mask("R$99");
  };

  window.closeMonthlyButton = function () {
    //console.log("closeMonthlyButton");
    var form = document.getElementById("formMonthly");
    form.style.display = "none";
  };

  window.updateMonthly = function (clientID) {
    var monthlyID = $("#monthlyID").val();
    var monthlyDatePay = $("#monthlyDatePay").val();
    var monthlyValue = $("#monthlyValue").val();
    monthlyValue = monthlyValue.replace(/\D/g, "");

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/monthly_update.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var messageServer = xmlhttp.responseText;
        if (messageServer == "")
          alert("Erro ao atualizar mensalidade, por favor tente novamente.");
        else {
          alert(messageServer);
          monthlyButton(clientID);
        }
      }
    };

    //console.log("monthlyID=" + monthlyID + "&datePay=" + monthlyDatePay + "&value=" + monthlyValue);
    var postInfo = "monthlyID=" + monthlyID + "&datePay=" + monthlyDatePay;
    postInfo += "&value=" + monthlyValue;

    xmlhttp.send(postInfo);
  };
});
