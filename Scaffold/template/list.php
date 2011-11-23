<?php
        header('Content-type: text/html; charset=utf-8');
?>
<style>
.bsscaffold_navbar
{
	border:1px solid  #dddddd;
	height:50px;
	background-color: #dddddd;
}
.bsscaffold_navbar_item {
	float: left;
	cursor: pointer;
	padding: 10px;
	background-color: #dddddd;
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
<div id="bsscaffold">
	<div class="bsscaffold_navbar">
		<div class="bsscaffold_navbar_item" action='create' title='Incluir Novo'>Novo</div>
		<!--  div class="bsscaffold_navbar_item" action='' title='Apagar Selecionados'>Apagar</div-->
		<div class="bsscaffold_navbar_item"> <input type='text' size='20' name='q' id='q'><input type='button' value='Pesquisar'></div>
	</div>
<br/><br/><br/><br/>
<div id="bsscaffold_data">
<?php
echo $bsscaffold_cname;
?>
		<table>
<?php
		echo "<tr>";
		foreach ($bsscaffold_columns as $column){
			echo "<th>{$column}</th>";
		}
		echo "<th>acões</th>";
		echo "</tr>";
		foreach ($bsscaffold_data as $datum){
			echo "<tr class='bsscaffold_tr'>";
			foreach ($bsscaffold_columns as $column){
				echo "<td align='center'>{$datum->$column}</td>";
			}
			echo "<td>";
//			echo "	<input class='bsscaffold_action' type='checkbox' name='bsscaffold_record[]' value='{$datum->$bsscaffold_indexname}'>";
			echo "	<div class='bsscaffold_action' action='/{$bsscaffold_cname}/{$bsscaffold_indexname}/{$datum->$bsscaffold_indexname}' title='Editar os dados'>E</div>
					<!--div class='bsscaffold_action'  title='apagar esta linha'>A</div-->
			</td>";
			echo "</tr>";
		}
			?>
		</table>
</div>
	<div class="bsscaffold_navbar">
		<div class="bsscaffold_navbar_item" action='2'  title='Próxima Página'>>></div>
		<div class="bsscaffold_navbar_item" action='1' title='Página Anterior' ><<</div>
	</div>

</div>
<script type="text/javascript">
	$('.bsscaffold_action').click(function(){
		$.get($(this).attr('action'), function(data){
		    $('#bsscaffold').html(data);
			});
	});
	$('.bsscaffold_navbar_item').click(
	   function()
	   {
		   console.log($(this).attr('name'));

    	});
</script>
