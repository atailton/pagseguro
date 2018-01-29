//SE NÃO GERAR O ID DA SESSÃO E SETAR ESSE ID NO setSessionId NADA VAI FUNCIONAR
//DEVE-SE GERAR A IDENTIFICAÇÃO DO USUÁRIO TAMBÉM
//SE FOR CARTÃO DE CRÉDITO DEVE-SE GERAR O TOKEN DO CARTÃO

$("#sessaoCad").click(function(){ //recebe codigo da dessão e seta o sessão id

        $.ajax({
            url : getUrl() + '/authenticate/index/iniciaPagamento',
            type : 'post',
            dataTyp : 'json',
            async : false,
            timeout: 20000,
            success: function(data){
                $(".retornoTeste").html(data);
                PagSeguroDirectPayment.setSessionId(data);
            }
        });

    });
	
$("#cadCPF").focus(function(){ //gera identificação do usuário

          identificador = PagSeguroDirectPayment.getSenderHash();
          $(".hashPagSeguro").val(identificador);

    });

PagSeguroDirectPayment.getBrand( {
          cardBin: bin,
          success: function(response) {

            $(".retornoTeste").html(response['brand']['name']);

            bandeira = response['brand']['name'];

            if(bandeira === 'elo'){
              $('#img-elo').css("border","3px solid #5d9afc");
            } else{$('#img-elo').css("border","3px solid white");}

            if(bandeira === 'visa'){
              $('#img-visa').css("border","3px solid #5d9afc");
            } else{$('#img-visa').css("border","3px solid white");}

            if(bandeira === 'mastercard'){
              $('#img-mastercard').css("border","3px solid #5d9afc");
            } else{$('#img-mastercard').css("border","3px solid white");}

            if(bandeira === 'hipercard'){
              $('#img-hipercard').css("border","3px solid #5d9afc");
            } else{$('#img-hipercard').css("border","3px solid white");}

            if(bandeira === 'amex'){
              $('#img-amex').css("border","3px solid #5d9afc");
            } else{$('#img-amex').css("border","3px solid white");}

          },
          error: function(response) {

          }
      });
	  
$("#parcelamento").click(function(){

        PagSeguroDirectPayment.getInstallments({
            amount: 49,
            maxInstallmentNoInterest: 1,
            //brand: 'visa',

            success: function(response){ console.log(response);},
            error: function(response){ console.log(response); }
        });

});

$("#cvv").keyup(function(){  //criar token

        numCartao = $("#numCartao").val();
        cvvCartao = $("#cvv").val();
        expiracaoMes = $("#pagamentoMes").val();
        expiracaoAno = $("#pagamentoAno").val();

        PagSeguroDirectPayment.createCardToken({
            cardNumber: numCartao,
            cvv: cvvCartao,
            expirationMonth: expiracaoMes,
            expirationYear: expiracaoAno,

            success: function(response){  $(".tokenPagamentoCartao").val(response['card']['token']);},
            error: function(response){ console.log(response); }
       });

    });

$("#meios").click(function(){ //meios de pagamento disponíveis

          PagSeguroDirectPayment.getPaymentMethods({
          amount: 500,
          success: function(response){ console.log(response); },
          error: function(response){ console.log(response); }
          });

    });
	

	  
