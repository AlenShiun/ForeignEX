<?php

require "vendor/autoload.php";
use PHPHtmlParser\Dom;

class Rate
{
    public $date;
    public $rate;
}

interface IRateParser
{
    /**
     * Parse rate from any data source
     * @return Rate array which should be ordered by date DESC
     */ 
    public function parse();
}

class OpenDataParser implements IRateParser
{
    public function parse() {
        $rates = Array();
        $content = file_get_contents('https://quality.data.gov.tw/dq_download_json.php?nid=11339&md5_url=f2fdbc21603c55b11aead08c84184b8f');
        $contentArray = json_decode($content, true);
        foreach($contentArray as $c) {
            $date = $c["日期"];
            $usdNtd = $c["美元／新台幣"];
            $usdJpy = $c["美元／日幣"];

            $jpyNtd = $usdNtd / $usdJpy;

            $r = new Rate();
            $r->date = $date;
            $r->rate = sprintf("%.4f", $jpyNtd);
            array_push($rates, $r);
        }
        $rates = array_reverse($rates);
        return $rates;
    }
}

?>

