<?php

//dados fornecidos pelo provider
$launch_url = 'https://lti.tools/test/tp.php'; //URL para teste
$consumer_key = 'jisc.ac.uk';
$secret = 'secret'; 

//dados do conteúdo a ser acessado
$contentTitle = 'Teste de conteúdo';
$contentId = '123';

//para gerar números randômicos com getTimestamp
$now = new DateTime();

//array com dados para o post
$launch_data = array();

//parâmetros gerais
$launch_data['context_id'] = $contentId;
$launch_data['context_title'] = $contentTitle;
$launch_data['roles'] = 'Learner'; // pode ser Instructor, etc...
$launch_data['user_id'] = '2'; 
$launch_data['resource_link_title'] = $contentTitle;
$launch_data['resource_link_id'] = $now->getTimestamp(); // precisa ser um número randômico para não usar o cachê
$launch_data['lti_message_type'] = 'basic-lti-launch-request';
$launch_data['lti_version'] = 'LTI-1p0';
$launch_data['tool_consumer_instance_guid'] = 'consumer_mgarlabx'; // string aleatório para identificar o consumer

//parâmetros OAuth 1.0
$launch_data['oauth_callback'] = 'about:blank';
$launch_data['oauth_consumer_key'] = $consumer_key;
$launch_data['oauth_nonce'] = uniqid( '', true );
$launch_data['oauth_signature_method'] = 'HMAC-SHA1';
$launch_data['oauth_timestamp'] = $now->getTimestamp();
$launch_data['oauth_version'] = '1.0';

//assinatura
$launch_data_keys = array_keys( $launch_data );
sort( $launch_data_keys );
$launch_params = array();
foreach ( $launch_data_keys as $key ) {
  array_push( $launch_params, $key . "=" . rawurlencode( $launch_data[$key] ) );
}
$base_string = 'POST&' . urlencode( $launch_url ) . '&' . rawurlencode( implode( '&', $launch_params ) );
$secret = urlencode( $secret ) . '&';
$signature = base64_encode(hash_hmac( 'sha1', $base_string, $secret, true ) );
$launch_data['oauth_signature'] = $signature;

//formulário

//$launch_url .= '?' . 'contentId=' . $contentId; //em alguns providers, a URL do post precisa conter a query string do contendId

$r = '<form id="form_ua" action="' . $launch_url. '" method="post" encType="application/x-www-form-urlencoded">' ;
foreach( $launch_data as $key => $value ) {
    $key = htmlspecialchars( $key );
    $value = htmlspecialchars( $value );
    $r .= '<input type="hidden" name="' . $key . '" value="' . $value . '"/>';
}
$r .= '<input type="submit" value="Abrir">';
$r .= "</form>";

//exibe formulário
echo $r;

?>

