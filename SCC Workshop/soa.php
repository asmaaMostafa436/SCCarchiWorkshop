<?php
 header("Access-Control-Allow-Origin: *");//bad practice to set the access control origin to wildcard
 //used wildcard here because client is deployed in undefined location(desktop, documents...etc)

    function formatTimestamp($time) {
        $dateTime = new DateTime($time);
        $dateTime->setTimezone(new DateTimeZone('America/Los_Angeles'));
        return $dateTime->format('d F Y, h:i:s a');
    }

  function formatChartDate($time) {
        $dateTime = new DateTime($time);
        $dateTime->setTimezone(new DateTimeZone('America/Los_Angeles'));
        return $dateTime->format('l, M d, Y');
    }

    function roundDecimal($num, $digit) {
        return number_format(round($num, $digit), $digit);
    }

    function formatMarketCap($val) {
        if ($val < 1000000) { // 1 million
            return round($val, 2);
        } else if ($val < 10000000) { // 10 millions
            return round($val / 1000000, 2) . ' Million';
        } else { // divide by billion
            return round($val / 1000000000, 2) . ' Billion';
        }
    }

    function getStockDetail($symbol) {
        $QUOTE_API = 'http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=';//make request to API from server
        $jsonString = file_get_contents($QUOTE_API . $symbol);
        $quote = json_decode($jsonString);

        $result = [];
        if ($quote->Status == 'SUCCESS') {
        //tell students to handle formatting in server or client which is better
            $result = array(
                'name' => $quote->Name,
                'symbol' => $quote->Symbol,
                'lastPrice' => $quote->LastPrice,
                'change' => roundDecimal($quote->Change, 2),
                'changePercent' => roundDecimal($quote->ChangePercent, 2),
                'stockTime' => formatTimestamp($quote->Timestamp),
                'marketCap' => formatMarketCap($quote->MarketCap),
                'volume' => $quote->Volume,
                'changeYTD' => roundDecimal($quote->ChangeYTD, 2),
                'changePercentYTD' => roundDecimal($quote->ChangePercentYTD, 2),
                'highPrice' => $quote->High,
                'lowPrice' => $quote->Low,
                'openPrice' => $quote->Open
            );
        }
        return $result;
    }

     if (isset($_GET['symbol'])) {
        $result = getStockDetail($_GET['symbol']);

        header('Content-Type: application/json');
        echo json_encode($result);
    } 
    
    else if (isset($_GET['chart'])) {
        $CHART_API = 'http://dev.markitondemand.com/MODApis/Api/v2/InteractiveChart/json?parameters={"Normalized":false,"NumberOfDays":1095,"DataPeriod":"Day","Elements":[{"Symbol":"' . $_GET['chart'] . '","Type":"price","Params":["ohlc"]}]}';
        $jsonString = file_get_contents($CHART_API);

        header('Content-Type: application/json');
        echo $jsonString;
    }
?>
