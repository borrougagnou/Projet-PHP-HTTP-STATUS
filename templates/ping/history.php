<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
	<link rel="stylesheet" href="http://185.163.125.75/css/show.css">
</head>
<body>
<h1> Historique de "<?php echo $query[0]['url']; ?>"</h1>
<p>
	<p>
	<h4>id : <?php echo $uid; ?></h4>
	<h4>url : <?php echo $query[0]['url'] ?></h4>
	</p>

	<?php
		$nblogs = count($query);
		for($i = 0; $i < $nblogs; $i++)
		{
	?>
		<div>
			<span class='myleft'>code :</span>
			<span class='myright'> <?php echo $query[$i]['status'];  ?> </span>
			<br />
			<span class='myleft'>check :</span>
			<span class='myright'> <?php echo $query[$i]['time']; ?> </span>
			<br />
		</div>
		<p></p>
	<?php
		}
	?>
</p>
<a href=".." >Retour à la page précédente</a>
