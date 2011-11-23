<?php
        header('Content-type: text/html; charset=utf-8');
?>
<style>
.bsscaffold_navbar
{
	height:50px;
}
.bsscaffold_navbar_item {
	float: left;
	cursor: pointer;
	padding: 10px;
	background-color: #dddddd;
	margin-left:20px;
}
#bsscaffold_data{
	width:100%;
}
.bsscaffold_action{
	float:left;
	padding:5px;
	cursor: pointer;
}
.bsscaffold_tr{
	border:bottom:1px solid #dddddd;
}
</style>
<div ="bsscaffold">
<h3>Editando Dados de <?php echo $bsscaffold_cname; ?></h3>
<div id="bsscaffold_data">
		<form method="POST" id="bsscaffold_form"  name="bsscaffold_form"
		action="<?php echo "/{$bsscaffold_cname}/{$bsscaffold_indexname}/{$bsscaffold_data->$bsscaffold_indexname}";?>"
		 name='<?php echo $bsscaffold_objtype; ?>'>
		<table>
<?php
		echo "</tr>";
			foreach ($bsscaffold_columns as $column){
				$name = $column->nome;
				if ($column->primarykey){
					echo "<input type='hidden' name=\"{$name}\"
						id=\"{$name}\"
						value=\"{$bsscaffold_data->$name}\">";
				}else{
					echo "<tr class='bsscaffold_tr'>";
					echo "<td>{$name}</td><td align='center'>
				<input type='text' name=\"{$name}\" id=\"{$name}\" size='40' value='{$bsscaffold_data->$name}'></td>";
					echo "</tr>";
				}
			}
			?>
		</table>
	<div class="bsscaffold_navbar">
		<input type='submit' name='save' id='save' class="bsscaffold_navbar_item" title='Gravar' value='Gravar'>
		<input type='submit' name='bssop' id='bssop' class="bsscaffold_navbar_item" title='Apagar' value='Apagar'>
	</div>
</form>
</div>
<?php
$headers = apache_request_headers();
if (array_key_exists('X-Requested-With', $headers)) {
?>
<script type="text/javascript">
	$('.bsscaffold_navbar_item').click(
	   function(event)
	   {
	       event.preventDefault();
		   var action = $('#bsscaffold_form').attr('action');
		   var datas   = $("#bsscaffold_form").serialize();
		   if ($(this).attr('id')=='bssop')
			   	datas+= "&bssop=apagar";
		   console.log(datas);
			$.post(action, datas, function(data){
			    $('#bsscaffold').html(data);
			});
    	});
</script>
<?php
}
?>
</div>
