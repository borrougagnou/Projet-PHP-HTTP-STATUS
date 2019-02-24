<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
	<link rel="stylesheet" href="http://185.163.125.75/css/show.css">
</head>
<body>
<h1> Disponibilité de "<?php echo $elem->url; ?>"</h1>
<p>
	<div>
		<span class='myleft'>id :</span>
		<span class='myright'> <?php echo $elem->id; ?> </span>
		<br />
		<span class='myleft'>url :</span>
		<span class='myright'> <?php echo $elem->url; ?> </span>
		<br />
		<span class='myleft'>code :</span>
		<span class='myright'> <?php echo $elem->code;  ?> </span>
		<br />
		<span class='myleft'>check :</span>
		<span class='myright'> <?php echo $elem->at; ?> </span>
		<br />
	</div>
</p>
<a href=".." >Retour à la page précédente</a>
