<?php

define("BLANK_COLUMN_VALUE", "");

define("COLUMN_END_TO_END_ID", "END_TO_END_ID");
define("COLUMN_AMT", "AMT");
define("COLUMN_BIC", "BIC");
define("COLUMN_IBAN", "IBAN");
define("COLUMN_RECEIVER_NAME", "RECEIVER_NAME");
define("COLUMN_RECEIVER_ADDRESS_COUNTRY", "RECEIVER_ADDRESS_COUNTRY");
define("COLUMN_PURPOSE", "PURPOSE");
define("COLUMN_DESCRIPTION", "DESCRIPTION");
define("COLUMN_CODE", "CODE");
define("COLUMN_ISSUER", "ISSUER");
define("COLUMN_REF", "REF");

define("DEFAULT_SHOW_END_TO_END_ID", 0);
define("DEFAULT_SHOW_AMT", 1);
define("DEFAULT_SHOW_BIC", 0);
define("DEFAULT_SHOW_IBAN", 1);
define("DEFAULT_SHOW_RECEIVER_NAME", 0);
define("DEFAULT_SHOW_RECEIVER_ADDRESS_COUNTRY", 0);
define("DEFAULT_SHOW_PURPOSE", 1);
define("DEFAULT_SHOW_DESCRIPTION", 0);
define("DEFAULT_SHOW_CODE", 0);
define("DEFAULT_SHOW_ISSUER", 0);
define("DEFAULT_SHOW_REF", 1);

define("COOKIE_END_TO_END_ID", "showEndToEndId");
define("COOKIE_AMT", "showAmt");
define("COOKIE_BIC", "showBIC");
define("COOKIE_IBAN", "showIBAN");
define("COOKIE_RECEIVER_NAME", "showReceiverName");
define("COOKIE_RECEIVER_ADDRESS_COUNTRY", "showReceiverAddressCountry");
define("COOKIE_PURPOSE", "showPurpose");
define("COOKIE_DESCRIPTION", "showDescription");
define("COOKIE_CODE", "showCode");
define("COOKIE_ISSUER", "showIssuer");
define("COOKIE_REF", "showRef");

define("POST_END_TO_END_ID", COOKIE_END_TO_END_ID);
define("POST_AMT", COOKIE_AMT);
define("POST_BIC", COOKIE_BIC);
define("POST_IBAN", COOKIE_IBAN);
define("POST_RECEIVER_NAME", COOKIE_RECEIVER_NAME);
define("POST_RECEIVER_ADDRESS_COUNTRY", COOKIE_RECEIVER_ADDRESS_COUNTRY);
define("POST_PURPOSE", COOKIE_PURPOSE);
define("POST_DESCRIPTION", COOKIE_DESCRIPTION);
define("POST_CODE", COOKIE_CODE);
define("POST_ISSUER", COOKIE_ISSUER);
define("POST_REF", COOKIE_REF);

$timeIn10Years = time() + (10 * 365 * 24 * 60 * 60);
if(isset($_POST[POST_END_TO_END_ID])) { setcookie(COOKIE_END_TO_END_ID, $_POST[POST_END_TO_END_ID], $timeIn10Years); }
if(isset($_POST[POST_AMT])) { setcookie(COOKIE_AMT, $_POST[POST_AMT], $timeIn10Years); }
if(isset($_POST[POST_BIC])) { setcookie(COOKIE_BIC, $_POST[POST_BIC], $timeIn10Years); }
if(isset($_POST[POST_IBAN])) { setcookie(COOKIE_IBAN, $_POST[POST_IBAN], $timeIn10Years); }
if(isset($_POST[POST_RECEIVER_NAME])) { setcookie(COOKIE_RECEIVER_NAME, $_POST[POST_RECEIVER_NAME], $timeIn10Years); }
if(isset($_POST[POST_RECEIVER_ADDRESS_COUNTRY])) { setcookie(COOKIE_RECEIVER_ADDRESS_COUNTRY, $_POST[POST_RECEIVER_ADDRESS_COUNTRY], $timeIn10Years); }
if(isset($_POST[POST_PURPOSE])) { setcookie(COOKIE_PURPOSE, $_POST[POST_PURPOSE], $timeIn10Years); }
if(isset($_POST[POST_CODE])) { setcookie(COOKIE_CODE, $_POST[POST_CODE], $timeIn10Years); }
if(isset($_POST[POST_DESCRIPTION])) { setcookie(COOKIE_DESCRIPTION, $_POST[POST_DESCRIPTION], $timeIn10Years); }
if(isset($_POST[POST_ISSUER])) { setcookie(COOKIE_ISSUER, $_POST[POST_ISSUER], $timeIn10Years); }
if(isset($_POST[POST_REF])) { setcookie(COOKIE_REF, $_POST[POST_REF], $timeIn10Years); }

function getValueFromParametersOrCookieOrDefault($postParameterName, $cookieName, $default){
    if(isset($_POST[$postParameterName]))
        return $_POST[$postParameterName];
    if(isset($_COOKIE[$cookieName]))
        return $_COOKIE[$cookieName];
    return $default;
}

$showEndToEndId = getValueFromParametersOrCookieOrDefault(POST_END_TO_END_ID, COOKIE_END_TO_END_ID, DEFAULT_SHOW_END_TO_END_ID);
$showAmt = getValueFromParametersOrCookieOrDefault(POST_AMT, COOKIE_AMT, DEFAULT_SHOW_AMT);
$showBIC = getValueFromParametersOrCookieOrDefault(POST_BIC, COOKIE_BIC, DEFAULT_SHOW_BIC);
$showIBAN = getValueFromParametersOrCookieOrDefault(POST_IBAN, COOKIE_IBAN, DEFAULT_SHOW_IBAN);
$showReceiverName = getValueFromParametersOrCookieOrDefault(POST_RECEIVER_NAME, COOKIE_RECEIVER_NAME, DEFAULT_SHOW_RECEIVER_NAME);
$showReceiverAddressCountry = getValueFromParametersOrCookieOrDefault(POST_RECEIVER_ADDRESS_COUNTRY, COOKIE_RECEIVER_ADDRESS_COUNTRY, DEFAULT_SHOW_RECEIVER_ADDRESS_COUNTRY);
$showPurpose = getValueFromParametersOrCookieOrDefault(POST_PURPOSE, COOKIE_PURPOSE, DEFAULT_SHOW_PURPOSE);
$showDescription = getValueFromParametersOrCookieOrDefault(POST_DESCRIPTION, COOKIE_DESCRIPTION, DEFAULT_SHOW_DESCRIPTION);
$showCode = getValueFromParametersOrCookieOrDefault(POST_CODE, COOKIE_CODE, DEFAULT_SHOW_CODE);
$showIssuer = getValueFromParametersOrCookieOrDefault(POST_ISSUER, COOKIE_ISSUER, DEFAULT_SHOW_ISSUER);
$showRef = getValueFromParametersOrCookieOrDefault(POST_REF, COOKIE_REF, DEFAULT_SHOW_REF);

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
print "<p><span><a href='sepa_instance_parser/'>Instance SEPA XML parser</a></span></p>";
print "<p>Which to use? Open the SEPA-XML file. Near the top it will either have http://www.w3.org/2001/XMLSchema or http://www.w3.org/2001/XMLSchema-instance. If it has XMLSchema-Instance, use the Instance SEPA XML parser, otherwise use this.";

print "<br><br>";
print "<h3>Insert your SEPA XML file's contents here</h3>";
print "
<form method='post'>
<textarea name='text' style='width: 400px; height: 200px;'>$myXMLData</textarea>
<br />
<input type='checkbox' name='utf8' value='1' ".($converToUTF8 ? "checked" : "")."> Convert to utf8
<br />
<h5>Display Parameters</h5>
<table style='margin-left: auto; margin-right: auto;'>
    <tr>
        <th style='text-align: right;'>End to end ID:</th>
        <td><input type='radio' name='".POST_END_TO_END_ID."' value='1' ".($showEndToEndId ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_END_TO_END_ID."' value='0' ".(!($showEndToEndId) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <th style='text-align: right;'>Purpose:</th>
        <td><input type='radio' name='".POST_PURPOSE."' value='1' ".($showPurpose ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_PURPOSE."' value='0' ".(!($showPurpose) ? "checked" : "")."> No</td>
    </tr>
    <tr>
        <th style='text-align: right;'>Amount:</th>
        <td><input type='radio' name='".POST_AMT."' value='1' ".($showAmt ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_AMT."' value='0' ".(!($showAmt) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <th style='text-align: right;'>Description:</th>
        <td><input type='radio' name='".POST_DESCRIPTION."' value='1' ".($showDescription ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_DESCRIPTION."' value='0' ".(!($showDescription) ? "checked" : "")."> No</td>
    </tr>
    <tr>
        <th style='text-align: right;'>BIC:</th>
        <td><input type='radio' name='".POST_BIC."' value='1' ".($showBIC ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_BIC."' value='0' ".(!($showBIC) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <th style='text-align: right;'>Code:</th>
        <td><input type='radio' name='".POST_CODE."' value='1' ".($showCode ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_CODE."' value='0' ".(!($showCode) ? "checked" : "")."> No</td>
    </tr>
    <tr>
        <th style='text-align: right;'>IBAN:</th>
        <td><input type='radio' name='".POST_IBAN."' value='1' ".($showIBAN ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_IBAN."' value='0' ".(!($showIBAN) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <th style='text-align: right;'>Issuer:</th>
        <td><input type='radio' name='".POST_ISSUER."' value='1' ".($showIssuer ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_ISSUER."' value='0' ".(!($showIssuer) ? "checked" : "")."> No</td>
    </tr>
    <tr>
        <th style='text-align: right;'>Receiver Name:</th>
        <td><input type='radio' name='".POST_RECEIVER_NAME."' value='1' ".($showReceiverName ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_RECEIVER_NAME."' value='0' ".(!($showReceiverName) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <th style='text-align: right;'>Reference:</th>
        <td><input type='radio' name='".POST_REF."' value='1' ".($showRef ? "checked" : "")."> Yes</td>
        <td><input type='radio' name='".POST_REF."' value='0' ".(!($showRef) ? "checked" : "")."> No</td>
    </tr>
    <tr>
    <th style='text-align: right;'>Receiver Address (Country):</th>
    <td><input type='radio' name='".POST_RECEIVER_ADDRESS_COUNTRY."' value='1' ".($showReceiverAddressCountry ? "checked" : "")."> Yes</td>
    <td><input type='radio' name='".POST_RECEIVER_ADDRESS_COUNTRY."' value='0' ".(!($showReceiverAddressCountry) ? "checked" : "")."> No</td>
        <td style='width: 25px;'></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
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

    foreach($xml as $tagNameOuter => $CstmrCdtTrfInitn){
        foreach($CstmrCdtTrfInitn as $paymentInformationTag => $PmtInf){
            if($paymentInformationTag != "PmtInf"){
                //skip elements other than payment information
                continue;
            }
            
            foreach($PmtInf as $CdtTrfTxInfTagName => $CdtTrfTxInf){
                if($CdtTrfTxInfTagName != "CdtTrfTxInf"){
                    //skip elements other than transaction information
                    continue;
                }

                $row = Array(
                    COLUMN_END_TO_END_ID => BLANK_COLUMN_VALUE,
                    COLUMN_AMT => BLANK_COLUMN_VALUE, 
                    COLUMN_BIC => BLANK_COLUMN_VALUE, 
                    COLUMN_IBAN => BLANK_COLUMN_VALUE, 
                    COLUMN_RECEIVER_NAME => BLANK_COLUMN_VALUE, 
                    COLUMN_RECEIVER_ADDRESS_COUNTRY => BLANK_COLUMN_VALUE, 
                    COLUMN_PURPOSE => BLANK_COLUMN_VALUE, 
                    COLUMN_DESCRIPTION => BLANK_COLUMN_VALUE, 
                    COLUMN_CODE => BLANK_COLUMN_VALUE, 
                    COLUMN_ISSUER => BLANK_COLUMN_VALUE, 
                    COLUMN_REF => BLANK_COLUMN_VALUE
                );
                
                if(isset($CdtTrfTxInf->PmtId->EndToEndId)){
                    $row[COLUMN_END_TO_END_ID] = $CdtTrfTxInf->PmtId->EndToEndId;
                }
                
                if(isset($CdtTrfTxInf->Amt->InstdAmt)){
                    $row[COLUMN_AMT] = $CdtTrfTxInf->Amt->InstdAmt;
                }
                
                if(isset($CdtTrfTxInf->CdtrAgt->FinInstnId->BIC)){
                    $row[COLUMN_BIC] = $CdtTrfTxInf->CdtrAgt->FinInstnId->BIC;
                }
                
                if(isset($CdtTrfTxInf->CdtrAcct->Id->IBAN)){
                    $iban = $CdtTrfTxInf->CdtrAcct->Id->IBAN;
                    $row[COLUMN_IBAN] = chunk_split($iban, 4, ' ');
                }
                
                if(isset($CdtTrfTxInf->Cdtr->Nm)){
                    $row[COLUMN_RECEIVER_NAME] = $CdtTrfTxInf->Cdtr->Nm;
                }
                
                if(isset($CdtTrfTxInf->Cdtr->PstlAdr->Ctry)){
                    $row[COLUMN_RECEIVER_ADDRESS_COUNTRY] = $CdtTrfTxInf->Cdtr->PstlAdr->Ctry;
                }
                
                if(isset($CdtTrfTxInf->Purp->Cd)){
                    $row[COLUMN_PURPOSE] = $CdtTrfTxInf->Purp->Cd;
                }
                
                if(isset($CdtTrfTxInf->RmtInf->Ustrd)){
                    $row[COLUMN_DESCRIPTION] = $CdtTrfTxInf->RmtInf->Ustrd;
                }
                
                if(isset($CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Tp->CdOrPrtry->Cd)){
                    $row[COLUMN_CODE] = $CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Tp->CdOrPrtry->Cd;
                }
                
                if(isset($CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Tp->Issr)){
                    $row[COLUMN_ISSUER] = $CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Tp->Issr;
                }
                
                if(isset($CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Ref)){
                    $ref = $CdtTrfTxInf->RmtInf->Strd->CdtrRefInf->Ref;
                    $row[COLUMN_REF] = substr_replace($ref, " ", 4, 0);
                }

                $data[] = $row;
            }
        }
    }
}

print "<h1>Relevant values</h1>";
print "<table width='900px' style='text-align: center; margin-left: auto; margin-right: auto;'>";
print "<tr>";
print " <th></th>";
if($showEndToEndId) print " <th>End to end ID</th>";
if($showAmt) print " <th>Amount</th>";
if($showBIC) print " <th>BIC</th>";
if($showIBAN) print " <th>IBAN</th>";
if($showReceiverName) print " <th>Receiver Name</th>";
if($showReceiverAddressCountry) print " <th>Receiver Address</th>";
if($showPurpose) print " <th>Purpose</th>";
if($showDescription) print " <th>Description</th>";
if($showCode) print " <th>Code</th>";
if($showIssuer) print " <th>Issuer</th>";
if($showRef) print " <th>Reference</th>";
print "</tr>";
foreach($data as $i => $receipt){
    print "<tr>";
    print " <td>$i</td>";
    if($showEndToEndId) print " <td>".$receipt[COLUMN_END_TO_END_ID]."</td>";
    if($showAmt) print " <td>".$receipt[COLUMN_AMT]."</td>";
    if($showBIC) print " <td>".$receipt[COLUMN_BIC]."</td>";
    if($showIBAN) print " <td>".$receipt[COLUMN_IBAN]."</td>";
    if($showReceiverName) print " <td>".$receipt[COLUMN_RECEIVER_NAME]."</td>";
    if($showReceiverAddressCountry) print " <td>".$receipt[COLUMN_RECEIVER_ADDRESS_COUNTRY]."</td>";
    if($showPurpose) print " <td>".$receipt[COLUMN_PURPOSE]."</td>";
    if($showDescription) print " <td>".$receipt[COLUMN_DESCRIPTION]."</td>";
    if($showCode) print " <td>".$receipt[COLUMN_CODE]."</td>";
    if($showIssuer) print " <td>".$receipt[COLUMN_ISSUER]."</td>";
    if($showRef) print " <td>".$receipt[COLUMN_REF]."</td>";
    print "</tr>";
}

print "</div>";
print "</div>";

?>