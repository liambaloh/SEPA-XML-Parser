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
print "<p><span><a href='../'>Normal SEPA XML parser</a></span></p>";
print "<p>Which to use? Open the SEPA-XML file. Near the top it will either have http://www.w3.org/2001/XMLSchema or http://www.w3.org/2001/XMLSchema-instance. If it has XMLSchema-Instance, use this SEPA XML parser, otherwise use the normal one.";

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
$data["BAL"] = Array();
$data["TXS"] = Array();
$data["NTRY"] = Array();

$xml = simplexml_load_string($myXMLData);
if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
	foreach($xml as $i => $BkToCstmrStmt){
		foreach($BkToCstmrStmt as $j => $parentElement){
			$parentTag = $parentElement->getName();
			if($parentTag != "Stmt"){
				continue;
			}
			foreach($parentElement as $k => $element){
				$tag = $element->getName();
				switch($tag){
					case "Bal":
						$amt = $element->Amt;
						$data["BAL"][] = Array("AMT" => $amt);
					break;
					case "TxsSummry":
						foreach($element as $l => $taxElement){
							$sum = $taxElement->Sum;
							$data["TXS"][] = Array("SUM" => $sum);
						}
					break;
					case "Ntry":
						$amt = $element->Amt;
						$debtorIban = $element->NtryDtls->TxDtls->RltdPties->DbtrAcct->Id->IBAN;
						$creditorIban = $element->NtryDtls->TxDtls->RltdPties->CdtrAcct->Id->IBAN;
						$data["NTRY"][] = Array(
							"AMT" => $amt,
							"DBTR_IBAN" => $debtorIban,
							"CDTR_IBAN" => $creditorIban,
						);
					break;
				}
			}
		}
	}
}

print "<h1>Relevant values</h1>";
foreach($data as $categoryName => $category){
	print "<h2>$categoryName</h2>";
	
	switch($categoryName){
		case "BAL":
			print "<table width='900px' style='text-align: center; margin-left: auto; margin-right: auto;'>";
			print "<tr><th width='100px'>Number</th><th width='200px'>Amount</th></tr>";
			foreach($category as $i => $row){
				print "<tr><th>$i</th><td>".$row["AMT"]."</td></tr>";
			}
			print "</table>";
		break;
		case "TXS":
			print "<table width='900px' style='text-align: center; margin-left: auto; margin-right: auto;'>";
			print "<tr><th width='100px'>Number</th><th width='200px'>Sum</th></tr>";
			foreach($category as $i => $row){
				print "<tr><th>$i</th><td>".$row["SUM"]."</td></tr>";
			}
			print "</table>";
		break;
		case "NTRY":
			print "<table width='900px' style='text-align: center; margin-left: auto; margin-right: auto;'>";
			print "<tr>
				<th width='100px'>Number</th>
				<th width='200px'>Amount</th>
				<th width='200px'>Debtor IBAN</th>
				<th width='200px'>Creditor IBAN</th>
				</tr>";
			foreach($category as $i => $row){
				print "<tr>
					<th>$i</th>
					<td>".$row["AMT"]."</td>
					<td>".$row["DBTR_IBAN"]."</td>
					<td>".$row["CDTR_IBAN"]."</td>
				</tr>";
			}
			print "</table>";
		break;
	}
}

print "</div>";
print "</div>";

?>