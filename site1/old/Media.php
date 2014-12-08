<script type="text/javascript">
function addRowToTable()
{
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  // if there's no header row in the table, then iteration = lastRow + 1
  var iteration = lastRow;
  var row = tbl.insertRow(lastRow);
  
  // left cell
  var cellLeft = row.insertCell(0);
  var textNode = document.createTextNode(iteration);
  cellLeft.appendChild(textNode);
  
  // right cell
  var cellRight = row.insertCell(1);
  var el = document.createElement('input');
  el.type = 'text';
  el.name = 'txtRow' + iteration;
  el.id = 'txtRow' + iteration;
  el.size = 40;
  cellRight.appendChild(el);  
 }

function removeRowFromTable()
{
  var tbl = document.getElementById('tblSample');
  var lastRow = tbl.rows.length;
  if (lastRow > 2) tbl.deleteRow(lastRow - 1);
}
</script>

<html>
<body>
<form action="sample.html">

<p>

<input type="button" value="Add" onclick="addRowToTable();" />

<input type="button" value="Remove" onclick="removeRowFromTable();" />

<input type="button" value="Submit" onclick="validateRow(this.form);" />

<input type="checkbox" id="chkValidate" /> Validate Submit

</p>

<p>

<input type="checkbox" id="chkValidateOnKeyPress" checked="checked" /> Display OnKeyPress

<span id="spanOutput" style="border: 1px solid #000; padding: 3px;"> </span>

</p>

<table border="1" id="tblSample">

<tr>

<th colspan="3">Sample table</th>

</tr>

<tr>

<td>1</td>

<td><input type="text" name="txtRow1"

id="txtRow1" size="40" /></td>



</tr>

</table>

</form>
</body>
</html>