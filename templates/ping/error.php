<?php include(PWD_TEMPLATES . '/incs/head.php'); ?>
</head>
<body>
<h1> Erreur <?php echo $code; ?></h1>
<p>
<?php
	echo "<h3>{$message}</h3>";
?>
</p>
<a href=".." >Retour à la page précédente</a>
