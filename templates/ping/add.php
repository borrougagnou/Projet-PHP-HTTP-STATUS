<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
	<link rel="stylesheet" href="http://185.163.125.75/css/add.css">
</head>
<body>

<h1> Ajout d'un websites </h1>
<p>
<?php
	if (empty($url))
	{
?>
		<form method='POST' action=''>
			<label for='Url'> Url:</label>
			<input type='text' name='url' />

			<div id='button'>
				<input type='submit' value='Ajouter le site' />
			</div>
		</form>
<?php
	}
	else if ($url === 'error')
		echo "désolé, ce n'est pas une URL valide";
	else if ($url === 'exist')
		echo "Cet URL existe déjà";
	else
	{
		echo "Votre site à bien été ajouté à la base";
	}
?>
</p>
<a href="." >Retour à la page précédente</a>
