<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head><title>ICICI Merchant Solution Sale API</title>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>

    <script src="lib/jquery.min.js"></script> 
    <script src="lib/jquery.validate.min.js"></script> 
    <script src="lib/additional-methods.min.js"></script>
    <script src="lib/validation.js"></script>
    <link rel="stylesheet" type="text/css" href="lib/style.css" media="screen">
</head>
<body>
<center><h1>Sale API</h1></center>
<hr>
<!-- The "Pay Now!" button submits the form and gives control to the form 'action' parameter -->
    <form action="processSale.php" method="post" id="saleApi" accept-charset="ISO-8859-1">

<!-- get user input -->
        <table width="80%" align="center" border="0" cellpadding='0' cellspacing='0'>
        <tr>
            <td colspan="2"><h3>ORDER PARAMETERS:</h3></td>
        </tr>
        <tr>
            <td width="300"><strong><em>Merchant Txn. Ref. No: *</em></strong></td>
            <td><input class="textbox"type="text" name="TxnRefNo" id="TxnRefNo" value="" required /></td>
        </tr>
        <tr>
            <td><strong><em>Amount in rupees: *</em></strong></td>
            <td><input class="textbox"type="text"  name="Amount" id="Amount" value="" pattern="[1-9]\d*(\.\d+)?" title="Please enter a number greater than or equal to 1" size="40" maxlength="12" required /></td>
        </tr>
        <tr>
            <td><strong><em>Currency Code: *</em></strong></td>
            <td><input class="textbox"type="text"  name="Currency" id="Currency" value="" size="50" maxlength="40" required /></td>
        </tr>
        <tr>
            <td><strong><em>Merchant Id: *</em></strong></td>
            <td><input class="textbox"type="text"  name="MerchantId" id="MerchantId" value="" required /></td>
        </tr>
        <tr>
            <td><strong><em>Terminal Id: *</em></strong></td>
            <td><input class="textbox"type="text"  name="TerminalId" id="TerminalId" value="" required /></td>
        </tr>
        <tr>
            <td><strong><em>Txn Type: *</em></strong></td>
            <td><input class="textbox"type="text"  name="TxnType" id="TxnType" value="Pay"  readonly="readonly" required /></td>
        </tr>
        <tr>
            <td><strong><em>Order ID: </em></strong></td>
            <td><input class="textbox"type="text"  name="OrderInfo" id="OrderInfo" /></td>
        </tr>
        <tr>
            <td><strong><em>Email: </em></strong></td>
            <td><input class="textbox"type="text"  name="Email" id="Email" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>FirstName: </em></strong></td>
            <td><input class="textbox" type="text"  name="FirstName" id="FirstName" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>LastName: </em></strong></td>
            <td><input class="textbox" type="text"  name="LastName" id="LastName" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>Street: </em></strong></td>
            <td><input class="textbox" type="text"  name="Street" id="Street" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>City: </em></strong></td>
            <td><input class="textbox" type="text"  name="City" id="City" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>State: </em></strong></td>
            <td><input class="textbox" type="text"  name="State" id="State" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>ZIP: </em></strong></td>
            <td><input class="textbox" type="text"  name="ZIP" id="ZIP" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>Phone: </em></strong></td>
            <td><input class="textbox" type="text"  name="Phone" id="Phone" value="" size="10" placeholder="1234567890" pattern="[0-9]{10}" maxlength="10"/></td>
        </tr>
		<tr>
          <td colspan="2"><h3>USER DEFINED FIELDS: </h3></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 01: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF01" id="UDF01" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 02: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF02" id="UDF02" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 03: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF03" id="UDF03" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 04: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF04" id="UDF04" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 05: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF05" id="UDF05" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 06: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF06" id="UDF06" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 07: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF07" id="UDF07" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 08: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF08" id="UDF08" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 09: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF09" id="UDF09" value=""/></td>
        </tr>
        <tr>
            <td><strong><em>User Defined Field 10: </em></strong></td>
            <td><input class="textbox"type="text"  name="UDF10" id="UDF10" value=""/></td>
       </tr>
        <tr>    
            <td>&nbsp;</td>
            <td><input type="submit" name="SubButL" value="Submit"/></td>
        </tr>
	</table>
    </form>
</body>
</html>
