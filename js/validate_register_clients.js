$(document).ready(function () {
  "use strict";
  /*
   * Global vars
   */
  var isValidForm;

  /*
   * Clear address to automate fill, after input states to blur
   */
  function clean_adress_form() {
    $("#street").val("");
    $("#district").val("");
    $("#states").html('<option value=""></option>');
    $("#cityID").html('<option value=""></option>');
  }

  /*
   * Put mask in the inputs
   */
  $("#cpf").mask("999.999.999-99");
  $("#birthDate").mask("99/99/9999");
  $("#cellPhone").mask("(99)99999-9999");
  $("#homePhone").mask("(99)9999-9999");
  $("#workPhone").mask("(99)9999-9999");
  $("#emergencyPhone").mask("(99)9999-9999");
  $("#beginDate").mask("99/99/9999");
  $("#value").mask("R$99");
  $("#cep").mask("99999-999");

  $("#stateID").change(function () {
    var stateID = $(this).val();
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "../js/ajax_data/option_cities.php", true);
    xmlhttp.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        document.getElementById("cityID").innerHTML = xmlhttp.responseText;
      }
    };
    xmlhttp.send("id=" + stateID);
  });

  /*
   * Get CEP and prepare for automatic fill inputs
   */
  $("#cep").blur(function () {
    var cep = $(this)
      .val()
      .replace(/\D/g, "");

    if (cep != "") {
      // regex for validate cep
      var validacep = /^[0-9]{8}$/;

      if (validacep.test(cep)) {
        $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (
          dados
        ) {
          if (!("erro" in dados)) {
            var state = dados.uf;
            var city = dados.localidade;
            var element;

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "../js/ajax_data/cep_state_city.php", true);
            xmlhttp.setRequestHeader(
              "Content-type",
              "application/x-www-form-urlencoded"
            );

            xmlhttp.onload = function () {
              var option = this.responseText;
              var delimiter = "";

              for (var i = 0; i < option.length; i++) {
                if (option.charAt(i) == ";") {
                  delimiter = i;
                  break;
                }
              }

              var stateID = option.substr(0, delimiter);
              var cityID = option.substr(delimiter + 1, option.length);

              //console.log("stateID: " + stateID + " cityId: " + cityId);

              clean_adress_form();

              $("#street").val(dados.logradouro);
              $("#district").val(dados.bairro);

              var option_state =
                '<option value="' + stateID + '">' + state + "</option>";
              var option_city =
                '<option value="' + cityID + '">' + city + "</option>";

              $("#stateID").html(option_state);
              $("#cityID").html(option_city);

              /*
                             * Validate address inputs, for not show error messages
                             */
              validateStreet();
              validateDistrict();
              validateSelect("stateID");
              validateSelect("cityID");

              var inputCEP = document.getElementById("cep");
              validElement(inputCEP);
            };

            xmlhttp.send("cityName=" + city + "&stateInitials=" + state);
          } else {
            //invalidElement();
            //console.log("Name CEP element: " + $(this).get(0).attr("name"));
            invalidElement($(this).get(0));
            var message = "CEP não encontrado";
            document.getElementById("validMessageCEP").innerHTML = message;
          }
        });
      } else {
        invalidElement($(this).get(0));
        var message = "Formato de CEP inválido.";
        document.getElementById("validMessageCEP").innerHTML = message;
      }
    } else {
      invalidElement($(this).get(0));
      var message = "É necessário informar um CEP.";
      document.getElementById("validMessageCEP").innerHTML = message;
    }
  }); // end of cep.blur

  // get state, city and street for fill the CEP input
  function getCEP() {
    var info = $("#stateID option:selected").text() + "/";
    info += $("#cityID option:selected").text() + "/";
    info += $("#street").val();
    var number = Number($("#number").val());
    var delimiter = "";
    var cep = [];
    var keyCEP = -1;

    $.ajaxSetup({
      async: false
    });

    $.getJSON("//viacep.com.br/ws/" + info + "/json/", function (data) {
      if (!("erro" in data)) {
        $.each(data, function (key, val) {
          cep[key] = val.cep;

          var complement = val.complemento;
          complement = complement.split("/");

          console.log("complement; " + complement);

          if (complement[0].search("de") != -1) {
            delimiter = Number(complement[0].replace(/^\D+/g, ""));

            if (number >= delimiter) keyCEP = key;
          } else if (complement[0].search("até") != -1) {
            delimiter = Number(complement[1].replace(/^\D+/g, ""));

            if (number <= delimiter) keyCEP = key;
          }

          console.log(
            "key: " + key + " delimiter: " + delimiter + " keyCEP:" + keyCEP
          );
        });
      }
    }); // end of getJSON

    if (keyCEP == -1)
      alert("Não foi possível encontrar o CEP do endereço informado");
    else {
      $("#cep").val(cep[keyCEP]);
      var inputCEP = $("#cep").get(0);
      validElement(inputCEP);
      document.getElementById("validMessageCEP").innerHTML = "";
    }

    $.ajaxSetup({
      async: true
    });
  }

  /*
   * Validade address number and get CEP if necessary or possible
   */
  function validateNumber() {
    var inputNumber = document.getElementById("number");
    var number = inputNumber.value;
    var regex = /\D/;
    var message = "";

    if (
      number.length > 6 ||
      number.length == 0 ||
      number == "" ||
      regex.test(number)
    ) {
      invalidElement(inputNumber);

      if (number.length == 0 || number == "") {
        message = "É necessário informar um número";
      } else if (number.length > 6) {
        message =
          "Número muito grande. Por favor verifique se eele está correto.";
      } else {
        message = "O campo número pode conter apenas digitos núméricos.";
      }
    } else {
      validElement(inputNumber);

      /*
       * Verify if is possible get CEP
       */
      if (
        $("#cep").val() == "" &&
        $("#street").val() != "" &&
        $("#district").val() != "" &&
        $("#cityID").val() != "none" &&
        $("#stateID").val() != "none"
      )
        getCEP();
    }

    document.getElementById("validMessageNumber").innerHTML = message;
  }

  /*
   * Util functions
   */
  String.prototype.capitalizeFirstLetter = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
  };

  /*
   * Form validations FUNCTIONS, for all elements that need
   */
  function validElement(element) {
    element.style.border = "2px solid green";
    element.style.color = "#000";
  }

  function invalidElement(element) {
    element.style.border = "2px solid red";
    element.style.color = "red";
    isValidForm = false;
  }

  function validateProfession() {
    var inputProfession = document.getElementById("profession");
    var profession = inputProfession.value;
    var regex = /^[a-zA-Z ]{2,60}$/;
    var message = "";

    if (!regex.test(profession)) {
      invalidElement(inputProfession);

      if (profession.length > 60)
        message = "Tamanho da profissão muito grande, por favor abrevie";
      else if (profession.length < 2)
        message = "A profissão precisa ter mais do que 2 caracteres";
      else {
        message =
          "O campo profissão não aceita caracteres especiais ou números. ";
        message += "Formato aceito: A-Z, a-z e espaços em branco";
      }

      //inputName.focus();
    } else {
      validElement(inputProfession);
    }

    document.getElementById("validMessageProfession").innerHTML = message;
  }

  function validateName() {
    var inputName = document.getElementById("name");
    var name = inputName.value;
    var regex = /^[a-zA-Z ]{2,60}$/;
    var message = "";

    if (!regex.test(name)) {
      invalidElement(inputName);

      if (name.length > 60)
        message = "Tamanho do nome muito grande, por favor abrevie";
      else if (name.length < 2)
        message = "O nome precisa ter mais do que 2 caracteres";
      else {
        message = "O campo nome não aceita caracteres especiais ou números. ";
        message += "Formato aceito: A-Z, a-z e espaços em branco";
      }

      //inputName.focus();
    } else {
      validElement(inputName);
    }

    document.getElementById("validMessageName").innerHTML = message;
  }

  function validateEmail() {
    var inputEmail = document.getElementById("email");
    var email = inputEmail.value;
    var regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var message = "";

    if (!regex.test(email) || email.length > 63) {
      invalidElement(inputEmail);

      if (email.length > 63)
        message = "O email não pode ultrapassar 63 caracteres";
      else message = "Formato de Email inválido!";

      //inputEmail.focus();
    } else {
      validElement(inputEmail);
    }

    document.getElementById("validMessageEmail").innerHTML = message;
  }

  function validateDate(dateID) {
    var inputDate = document.getElementById(dateID);
    var date = inputDate.value;
    var regex = /^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/;
    var message = "";
    var messageID = "validMessage" + dateID.capitalizeFirstLetter();

    if (!regex.test(date)) {
      invalidElement(inputDate);

      message = "Formato de data inválida, por favor siga o formato.";
      message += "Formato: DD/MM/AAAA (Dia/Mês/Ano)";

      //inputDate.focus();
    } else validElement(inputDate);

    document.getElementById(messageID).innerHTML = message;
  }

  function validatePhone(phoneID) {
    var inputPhone = document.getElementById(phoneID);
    var phone = inputPhone.value;
    var regex = /^\(([1-9]{2})\)([2-9][0-9]{3,4})\-([0-9]{4})$/;
    var message = "";
    var messageID = "validMessage" + phoneID.capitalizeFirstLetter();

    if (!regex.test(phone)) {
      invalidElement(inputPhone);

      message = "Formato de telefone iválido, por favor siga o formato: ";
      if (phoneID == "cellPhone") message += "(xx) xxxxx-xxxx";
      else message += "(xx) xxxx-xxxx";

      //inputPhone.focus();
    } else {
      validElement(inputPhone);
    }

    document.getElementById(messageID).innerHTML = message;
  }

  function validateRadio(radioName) {
    var inputRadio = document.getElementsByName(radioName);
    var radio = inputRadio.checked;
    var message = "";
    var messageID = "validMessage" + radioName.capitalizeFirstLetter();
    alert(messageID);

    if (radio == false) {
      invalidElement(inputRadio);
      message = "Por favor escolha uma opção";
      //inputRadio.focus();
    }
    //validElement(inputRadio);

    document.getElementById(messageID).innerHTML = message;
  }

  function validateCPF() {
    var inputCPF = document.getElementById("cpf");
    var cpf = inputCPF.value;
    cpf = cpf.replace(/\D/g, "");
    var numeros, digitos, soma, i, resultado, digitos_iguais, validate;
    var message = "";

    digitos_iguais = 1;
    validate = true;

    if (cpf.length < 11 || cpf == "") {
      invalidElement(inputCPF);
      validate = false;
      message = "Formato de CPF inválido. Por favor siga o formato: ";
      message += "xxx.xxx.xxx-xx";
    } else {
      for (i = 0; i < cpf.length - 1; i++) {
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
          digitos_iguais = 0;
          break;
        }
      }

      if (!digitos_iguais) {
        numeros = cpf.substring(0, 9);
        digitos = cpf.substring(9);
        soma = 0;

        for (i = 10; i > 1; i--) soma += numeros.charAt(10 - i) * i;

        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);
        if (resultado != digitos.charAt(0)) validate = false;

        numeros = cpf.substring(0, 10);
        soma = 0;

        for (i = 11; i > 1; i--) soma += numeros.charAt(11 - i) * i;

        resultado = soma % 11 < 2 ? 0 : 11 - (soma % 11);

        if (resultado != digitos.charAt(1)) validate = false;
      } else {
        validate = false;
      }

      if (validate == true) {
        validElement(inputCPF);
      } else {
        invalidElement(inputCPF);
        message = "Número de CPF inválido";
        //inputCPF.focus();
      }
    }

    document.getElementById("validMessageCPF").innerHTML = message;
  }

  function validateRG() {
    var inputRG = document.getElementById("rg");
    var rg = inputRG.value;
    rg = rg.replace(/\D/g, "");
    var message = "";

    if (rg.length > 13 || rg.length == 0 || rg == "") {
      invalidElement(inputRG);

      if (rg.length > 13) {
        message = "Número de RG muito grande. Por favor verifique ";
        message += "se o RG digitado está correto";
      } else {
        message = "RG inválido";
      }
      //inputRG.focus();
    } else {
      validElement(inputRG);
    }

    document.getElementById("validMessageRG").innerHTML = message;
  }

  function validateSelect(selectID) {
    var inputSelect = document.getElementById(selectID);
    var select = inputSelect.value;
    var messageID = "validMessage" + selectID.capitalizeFirstLetter();
    var message = "";

    if (select == "none") {
      invalidElement(inputSelect);
      message = "Por favor escolha uma opção";
      //inputSelect.focus();
    } else {
      validElement(inputSelect);
    }

    document.getElementById(messageID).innerHTML = message;
  }

  function validateObservation() {
    var inputObservation = document.getElementById("observation");
    var observation = inputObservation.value;
    var message = "";

    if (
      observation.length > 250 ||
      observation.length == 0 ||
      observation == ""
    ) {
      invalidElement(inputObservation);

      if (observation.length == 0 || observation == "") {
        message = "É necessário uma observação";
      } else {
        message = "Texto muito grande para uma observação. Por favor tente ";
        message += "abreviá-la. Tamanho máximo 250 caracteres";
      }

      //inputObservation.focus();
    } else {
      validElement(inputObservation);
    }

    document.getElementById("validMessageObservation").innerHTML = message;
  }

  function validateDistrict() {
    var inputDistrict = document.getElementById("district");
    var district = inputDistrict.value;
    var message = "";

    if (district.length > 50 || district.length == 0 || district == "") {
      invalidElement(inputDistrict);

      if (district.length == 0 || district == "") {
        message = "É necessário informar um bairro";
      } else {
        message = "Nome de bairro muito grande. Por favor tente abreviá-lo.";
      }

      //inputDistrict.focus();
    } else {
      validElement(inputDistrict);
    }

    document.getElementById("validMessageDistrict").innerHTML = message;
  }

  function validateStreet() {
    var inputStreet = document.getElementById("street");
    var street = inputStreet.value;
    var message = "";

    if (street.length > 60 || street.length == 0 || street == "") {
      invalidElement(inputStreet);

      if (street.length == 0 || street == "") {
        message = "É necessário informar uma rua";
      } else {
        message = "Nome de rua muito grande. Por favor tente abreviá-la.";
      }

      //inputStreet.focus();
    } else {
      validElement(inputStreet);
    }

    document.getElementById("validMessageStreet").innerHTML = message;
  }

  function validateValue() {
    var inputValue = document.getElementById("value");
    var value = inputValue.value;
    value = value.replace(/\D/g, "");
    var message = "";

    if (value == "" || value == 0) {
      invalidElement(inputValue);

      message = "Valor da mensalidade é nulo. Se pretende cadastrar um ";
      message += "cliente gratuito, apenas ignore essa mensagem.";
    } else {
      validElement(inputValue);
    }

    document.getElementById("validMessageValue").innerHTML = message;
  }

  /*
   * Form validatiors object, contained all elements input and your respective
   * validade function.
   */
  var formValidators = [
    {
      id: "#name",
      function: validateName()
    },
    {
      id: "#email",
      function: validateEmail()
    },
    {
      id: "#birthDate",
      function: validateDate("birthDate")
    },
    {
      id: "#beginDate",
      function: validateDate("beginDate")
    },
    {
      id: "#cellPhone",
      function: validatePhone("cellPhone")
    },
    {
      id: "#homePhone",
      function: validatePhone("homePhone")
    },
    {
      id: "#workPhone",
      function: validatePhone("workPhone")
    },
    {
      id: "#emergyPhone",
      function: validatePhone("emergencyPhone")
    },
    {
      id: "#gender",
      function: validateRadio("gender")
    },
    {
      id: "#noInstructor",
      function: validateRadio("noInstructor")
    },
    {
      id: "#cpf",
      function: validateCPF()
    },
    {
      id: "#rg",
      function: validateRG()
    },
    {
      id: "#civilStatus",
      function: validateSelect("civilStatus")
    },
    {
      id: "#stateID",
      function: validateSelect("stateID")
    },
    {
      id: "#cityID",
      function: validateSelect("cityID")
    },
    {
      id: "#schoolingID",
      function: validateSelect("schoolingID")
    },
    {
      id: "#district",
      function: validateDistrict()
    },
    {
      id: "#street",
      function: validateStreet()
    },
    {
      id: "#number",
      function: validateNumber()
    },
    {
      id: "#observation",
      function: validateObservation()
    },
    {
      id: "#value",
      function: validateValue()
    },
    {
      id: "#profession",
      function: validateProfession()
    }
  ];

  /*
   * Listen blur for all elements input contained in formValidators object
   */
  formValidators.forEach(element => {
    $(element.id).blur(function () {
      element.function;
    });
  });

  /*
   * Register client click
   */
  $("#registerButton").click(function () {
    isValidForm = true;

    // Validate all elements input contained in formValidators object
    formValidators.forEach(element => {
      element.function;
    });

    if (isValidForm) {
      document.getElementById("registerClientsForm").submit();
    } else {
      var message = "Existem campos inválidos ou não preenchidos. ";
      message += "Por favor corrija-os e tente novamente.";
      alert(message);
    }
  });

  $("#cancelButton").click(function () {
    window.location.assign("index.php");
  });
});
