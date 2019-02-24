<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
</head>
<body>

<h1> Liste des websites </h1>
<a id='addtoto' href="<?php $this->s(Router::url('Ping', 'addhtml')); ?>">Ajouter un website</a>
<div id='radiustable'>
	<table>
		<tr>
			<th>ID</th>
			<th>URL</th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
		<?php
			for($i = 0; $i < $nbsites; $i++)
			{
				echo '<tr>';
				echo "<th>{$result[$i]['id']}</th>";
				echo "<th>{$result[$i]['url']}</th>";
				echo '<th><a href="' . Router::url('Ping', 'statushtml', ['uid' => $result[$i]['id']]) . '">DETAIL</a></th>';
				echo '<th><a href="' . Router::url('Ping', 'historyhtml', ['uid' => $result[$i]['id']]) . '">HISTORIQUE</a></th>';
				echo '<th><a href="' . Router::url('Ping', 'mydelete', ['uid' => $result[$i]['id']]) . '">SUPPRIMER</a></th>';
				echo '</tr>';
			}
		?>
	</table>
</div>
