<?php

if(isset($_SESSION['error'])){
	echo "
	<div id='messagbox' class='boxmsg'>
	<div id='bordesbox' class='alert-box3 alert-danger alert-dismissible col-md-12 auto'>
	<h4><i class='icon fa fa-warning'></i> Erro!</h4>
	".$_SESSION['error']."
	</div>
	</div>
	";
	unset($_SESSION['error']);
}

if(isset($_SESSION['alertt'])){
	echo "
	<div id='messagbox' class='boxmsg'>
	<div id='bordesbox' class='alert-box3 alert-warning  alert-dismissible col-md-12 auto'>
	<h4><i class='fas fa-exclamation-circle'></i> Alerta!</h4>
	".$_SESSION['alertt']."
	</div>
	</div>
	";
	unset($_SESSION['alertt']);
}

if(isset($_SESSION['danger'])){
	echo "
	<div id='messagbox' class='boxmsg'>
	<div id='bordesbox' class='alert-box3 alert-danger alert-dismissible col-md-12 auto'>
	<h4><i class='fas fa-exclamation-circle'></i> Alerta!</h4>
	".$_SESSION['danger']."
	</div>
	</div>
	";
	unset($_SESSION['danger']);
}

if(isset($_SESSION['success'])){
	echo "
	<div id='messagbox' class='boxmsg'>
	<div id='bordesbox' class='alert-box3 alert-success alert-dismissible col-md-12 auto'>
	<h4><i class='icon fa fa-check'></i> Successo!</h4>
	".$_SESSION['success']."
	</div>
	</div>
	";
	unset($_SESSION['success']);
}

if(isset($_SESSION['info'])){
	echo "
	<div id='messagbox' class='boxmsg'>
	<div id='bordesbox' class='alert-box3 alert-info alert-dismissible col-md-12 auto'>
	<h4><i class='icon fa fa-check'></i> Info!</h4>
	".$_SESSION['info']."
	</div>
	</div>
	";
	unset($_SESSION['success']);
}

?>