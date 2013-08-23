<?php
header ('Content-type: text/html; charset=utf-8');

//$url = "http://wap.nastabuss.se/its4wap/QueryForm.aspx?hpl=Resecentrum+(V%C3%A4xj%C3%B6)";
//$url = "http://localhost/NextBus/sample%20html/Resecentrum+(V%C3%A4xj%C3%B6).html";
if(!empty($_GET['url']))
	$url = $_GET['url'];
else
	$url = "http://crossplatform.co.nf/sample%20html/Resecentrum+(V%C3%A4xj%C3%B6).html";


$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
$output = curl_exec($curl);
curl_close($curl);

$DOM = new DOMDocument;
$DOM->loadHTML($output);
//print $DOM->length;
//echo '<pre>';print_r($DOM);
//die();

$xpath = new DOMXPath($DOM);
$tags = $xpath->query('//span[@id="LabelForecasts"]');
$tag_data = array();
foreach ($tags as $tag) {
	if(trim($tag->nodeValue) != "")
	    $tag_data[] = trim($tag->nodeValue);
}

$tags = $xpath->query('//span[@id="LabelTimeandStop"]');
foreach ($tags as $tag) {
    if(trim($tag->nodeValue) != "")
	    $tag_data[] = trim($tag->nodeValue);
}

$tags = $xpath->query('//table[@id="GridViewForecasts"]/tr[@class="darkblue_pane"]/th');
foreach ($tags as $tag) {
	if(trim($tag->nodeValue) != ""){
		$str = trim($tag->nodeValue);
		$tag_data[] = str_replace("&nbsp;","",$str);
	}
		
}

$tags = $xpath->query('//table[@id="GridViewForecasts"]/tr[@class="white_pane"]/td | //table[@id="GridViewForecasts"]/tr[@class="lightblue_pane"]/td');
foreach ($tags as $tag) {
    if(trim($tag->nodeValue) != "")
	    $tag_data[] = trim($tag->nodeValue);
}
//echo '<pre>';print_r($tag_data);
echo json_encode($tag_data);

?>