public function efetuaPagamentoCartao($dados) {


		$data['token'] ='SEU TOKEN PAGSEGURO'; //token sandbox ou produção
		$data['paymentMode'] = 'default';
		$data['senderHash'] = $dados['hash']; //gerado via javascript
		$data['creditCardToken'] = $dados['creditCardToken']; //gerado via javascript
		$data['paymentMethod'] = 'creditCard';
		$data['receiverEmail'] = 'e-mail cadastrado no pagseguro não é o do cliente';
		$data['senderName'] = $dados['senderName']; //nome do usuário deve conter nome e sobrenome
		$data['senderAreaCode'] = $dados['senderAreaCode'];
		$data['senderPhone'] = $dados['senderPhone'];
		$data['senderEmail'] = $dados['senderEmail'];
		$data['senderCPF'] = $dados['senderCPF'];
		$data['installmentQuantity'] = '1';
		//$data['noInterestInstallmentQuantity'] = '1';
		$data['installmentValue'] = $dados['installmentValue']; //valor da parcela
		$data['creditCardHolderName'] = $dados['creditCardHolderName']; //master, vista etc
		$data['creditCardHolderCPF'] = $dados['creditCardHolderCPF'];
		$data['creditCardHolderBirthDate'] = $dados['creditCardHolderBirthDate'];
		$data['creditCardHolderAreaCode'] = $dados['creditCardHolderAreaCode'];
		$data['creditCardHolderPhone'] = $dados['creditCardHolderPhone'];
		$data['billingAddressStreet'] = $dados['billingAddressStreet'];
		$data['billingAddressNumber'] = $dados['billingAddressNumber'];
		$data['billingAddressDistrict'] = $dados['billingAddressDistrict'];
		$data['billingAddressPostalCode'] = $dados['billingAddressPostalCode'];
		$data['billingAddressCity'] = $dados['billingAddressCity'];
		$data['billingAddressState'] = $dados['billingAddressState'];
		$data['billingAddressCountry'] = 'Brasil';
		$data['currency'] = 'BRL';
		$data['itemId1'] = '01';
		$data['itemQuantity1'] = '1';
		$data['itemDescription1'] = 'Descrição do item';
		$data['reference'] = $dados['reference']; //referencia qualquer do produto
		$data['shippingAddressRequired'] = 'false';
		$data['itemAmount1'] = $dados['itemAmount1'];

				//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = "e-mail cadastrado no pagseguro";

		$data = http_build_query($data);
		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //URL de teste


		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml= simplexml_load_string($xml);


		//echo $xml -> paymentLink;
		$code =  $xml -> code;
		$date =  $xml -> date;
		
		//aqui eu ja trato o xml e pego o dado que eu quero, vc pode dar um var_dump no $xml e ver qual dado quer

		$retornoCartao = array(
				'code' => $code,
				'date' => $date
		);

		return $retornoCartao;

	}

	public function efetuaPagamentoBoleto($dados) {


		$data['token'] ='seu token do pagseguro disponível no login sandbox'; //token sandbox test
		$data['paymentMode'] = 'default';
		$data['hash'] = $dados['hash'];
		$data['paymentMethod'] = 'boleto';
		$data['receiverEmail'] = 'e-mail cadastrado no pagseguro não é o do cliente';
		$data['senderName'] = $dados['senderName'];
		$data['senderAreaCode'] = $dados['senderAreaCode'];
		$data['senderPhone'] = $dados['senderPhone'];
		$data['senderEmail'] = $dados['senderEmail'];
		if($dados['senderCPF'] != null){$data['senderCPF'] = $dados['senderCPF'];}
		if($dados['senderCNPJ'] != null){$data['senderCNPJ'] = $dados['senderCNPJ'];}
		$data['currency'] = 'BRL';
		$data['itemId1'] = $dados['itemId1'];
		$data['itemQuantity1'] =$dados['itemQuantity1'];
		$data['itemDescription1'] = $dados['itemDescription1'];
		$data['reference'] = $dados['reference'];
		$data['shippingAddressRequired'] = 'false';
		$data['itemAmount1'] = $dados['itemAmount1'];

				//$_SERVER['REMOTE_ADDR']
		$emailPagseguro = "e-mail cadastrado no pagseguro não é o do cliente";

		$data = http_build_query($data);
		$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //URL de teste


		$curl = curl_init();

		$headers = array('Content-Type: application/x-www-form-urlencoded; charset=ISO-8859-1'
			);

		curl_setopt($curl, CURLOPT_URL, $url . "?email=" . $emailPagseguro);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt( $curl,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $curl,CURLOPT_RETURNTRANSFER, true );
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		//curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($curl, CURLOPT_HEADER, false);
		$xml = curl_exec($curl);

		curl_close($curl);

		$xml= simplexml_load_string($xml);


		//echo $xml -> paymentLink;
		$boletoLink =  $xml -> paymentLink;
		$code =  $xml -> code;
		$date =  $xml -> date;
		
		//aqui eu ja trato o xml e pego o dado que eu quero, vc pode dar um var_dump no $xml e ver qual dado quer

		$retornoBoleto = array(
				'paymentLink' => $boletoLink,
				'date' => $date,
				'code' => $code
		);

		return $retornoBoleto;

	}