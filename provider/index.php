<?php


$host = $_SERVER['HTTP_HOST'];
$query = $_SERVER['QUERY_STRING'];

if ( $host == 'localhost' ) {
	$launch_url = 'http://localhost/SitesPhP/lti/provider/';	
}
else if ( $host == 'solvertank.com' ) {
	$launch_url = 'http://solvertank.com/lti/provider/';	
}
else if ( $host == 'mgar2.websiteseguro.com' ) {
	$launch_url = 'https://mgar2.websiteseguro.com/lti/provider/';	
}

//add query string (if exists)
if ( $query != '' ) $launch_url .= '?' . $query;

$shared_secret = '456789';


echo '<h2>Parâmetros do POST</h2>'; 

//read post
$post = json_decode( file_get_contents( 'php://input' ), true );
$type = 'raw';

if ( $post == null ) {
	$post = $_POST;
	$type = 'form-data (1)';
}
else if ( sizeof( $post ) == 0 ) {
	$post = $_POST;
	$type = 'form-data (2)';
}

echo 'URL: ' . $launch_url . '<br>';
echo 'Tipo de POST: ' . $type . '<p><hr><p>';

echo '<table>';
$launch_data = array();
foreach( $post as $key => $value ) {	
	echo '<tr>';
	echo '<td style="padding-right:20px;background-color:#C0C0C0;">' . $key . '</td>';
	echo '<td style="padding-right:20px;background-color:#F0F0F0;">' . $value . '</td>';
	echo '</tr>';
	if ( $key != 'oauth_signature' ) $launch_data[$key] = $value;
}	
echo '</table>';

//ordenando os parâmetros e gerando a assinatura
$launch_data_keys = array_keys( $launch_data );
sort( $launch_data_keys );
$launch_params = array();
foreach ( $launch_data_keys as $key ) {
  array_push( $launch_params, $key . '=' . rawurlencode( $launch_data[$key] ) );
}
$base_string = 'POST&' . urlencode( $launch_url ) . '&' . rawurlencode( implode( '&', $launch_params ) );
$shared_secret = urlencode( $shared_secret ) . '&';
$signature = base64_encode( hash_hmac( 'sha1', $base_string, $shared_secret, true ) );

echo '<hr>';
echo 'SIGN calculada: '  . $signature . '<p>';
echo 'SIGN postadada: ' . $post['oauth_signature'] . '<p>';
echo 'shared_secret: ' . $shared_secret . '<p><hr>';
echo 'base_string: ' . $base_string . '<p>';


?>
