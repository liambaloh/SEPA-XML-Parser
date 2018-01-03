<?php

print "<div style='text-align: center;'>";
print "<div style='width: 1000px; margin-left: auto; margin-right: auto;'>";

libxml_use_internal_errors(true);
$myXMLData = (isset($_POST["text"])) ? $_POST["text"] : "";
$converToUTF8 = (isset($_POST["utf8"])) ? $_POST["utf8"] : "";

if($converToUTF8 == 1){
	$myXMLData = utf8_encode($myXMLData);
}

print "<h1>SEPA XML PARSER</h1>";
print "<span style='font-style: italic;'>Pay your taxes easier™</span>";

print "<br><br>";
print "<h3>Insert your SEPA XML file's contents here</h3>";
print "
<form method='post'>
<textarea name='text' style='width: 400px; height: 200px;'>$myXMLData</textarea>
<br />
<input type='checkbox' name='utf8' value='1' ".($converToUTF8 ? "checked" : "")."> Convert to utf8
<br />
<br />
Disclaimer: If you actually somehow got to this page on your own and want to use this tool, be aware that the contents submitted above will be sent to our web server, unencrypted. 
They are processed on our server and you get the results, again, unencrypted. We obviously don't store anything that comes in through this tool, as it's intended for internal use, but
please don't send sensitive information.
<br />
<br />
<input type='submit'>
</form>";

$data = Array();

$xml = simplexml_load_string($myXMLData);
if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
    foreach($xml as $i => $CstmrCdtTrfInitn){
        foreach($CstmrCdtTrfInitn as $j => $PmtInf){
            $row = Array();
            $row["AMT"] = $PmtInf->CdtTrfTxInf->Amt->InstdAmt;
            $iban = $PmtInf->CdtTrfTxInf->CdtrAcct->Id->IBAN;
            $row["IBAN"] = chunk_split($iban, 4, ' ');
            $row["PURPOSE"] = $PmtInf->CdtTrfTxInf->Purp->Cd;
            $ref = $PmtInf->CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Ref;
            $row["REF"] = substr_replace($ref, " ", 4, 0);
            if($row["AMT"] != ""){
                $data[] = $row;
            }
        }
    }

}


print "<h1>Relevant values</h1>";
print "<table width='900px' style='text-align: center; margin-left: auto; margin-right: auto;'>";
print "<tr><th width='100px'></th><th width='100px'>Amount</th><th width='400px'>IBAN</th><th width='100px'>Purpose</th><th width='100px'>Reference</th></tr>";
foreach($data as $i => $bill){
    print "<tr><td>$i</td><td>".$bill["AMT"]."</td><td>".$bill["IBAN"]."</td><td>".$bill["PURPOSE"]."</td><td>".$bill["REF"]."</td></tr>";
}

print "</div>";
print "</div>";

?>