<?php

$DATA = json_decode(file_get_contents("https://www.binance.com/api/v1/ticker/allPrices"),true);
header("Content-type: application/json; charset=utf-8");
function isValidCurrency($currency){
global $DATA;
$LISR = array_column($DATA, 'symbol');
foreach($LISR as $key){
$NAMEs[] = substr($key,0,3);
}
$currencyList = array_unique($NAMEs);
return in_array($currency,$currencyList);
}
if(!empty($_REQUEST['n'])){
$ARZ_NAME =  explode(",",strtoupper($_REQUEST['n']));
$DOLAR =  $DATA[array_search("BTCUSDT", array_column($DATA, 'symbol'))]['price'];
foreach($ARZ_NAME as $key => $value){
if(isValidCurrency($value)){
if($value == "BTC"){
$PRICR = $DOLAR * 1;    
}else{
$key = array_search($value."BTC", array_column($DATA, 'symbol'));
$PRICR = $DATA[$key]['price'] * $DOLAR;        
}

$RESULT[$value] = $PRICR ;
}else{
$RESULT[$value] = "Isn`t Vali Currency" ;
}
}
}else{
$RESULT['ERROR'] = "'n' is empty." ;   
}
echo json_encode(["status"=>'True',"result"=>$RESULT]);
?>
