<?php 
	$form_index = json_decode( get_option(  $this->get_root()->get_prefix( 'index' ) ) ); 
	$form_labels = get_terms( $this->taxonomy->get_taxonomy() );
?>

<h2>Form Index</h2>
<table class="sv_table">
	<thead>
		<tr>
			<th>ID</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		if ( ! empty( $form_index ) ) {
			foreach( $form_index as $id ) {
				echo '<tr>';
				echo '<td>' . $id . '</td>';
				echo '</tr>';
			}
		}
	?>
	</tbody>
</table>

<h2>Form Labels</h2>
<table class="sv_table">
	<thead>
		<tr>
			<th>Slug</th>
			<th>Name</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		if ( ! empty( $form_labels ) ) {
			foreach( $form_labels as $label ) {
				echo '<tr>';
				echo '<td>' . $label->slug . '</td>';
				echo '<td>' . $label->name . '</td>';
				echo '</tr>';
			}
		}
	?>
	</tbody>
</table>

<style>
	table.sv_table {
		width: 100%;
		border-collapse: collapse;
	}
	table.sv_table tr th {
		background-color: rgba(0,0,0,.5);
		color: rgba(255,255,255, .9);
	}
	table.sv_table tr:nth-child(even) td {
		background-color: rgba(0,0,0,.1);
	}
</style>