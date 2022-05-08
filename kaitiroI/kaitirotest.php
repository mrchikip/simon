<!DOCTYPE html> 
<style type="text/css"> </style>
<html>
<head>
<meta charset="utf-8">
<title>KAITIRO APP</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="kaitiroAssets/styles/kaitiroStyle.css" rel="stylesheet" type="text/css">
</head>

<body>

<div id="mainWrapper">
  <header>
    <div id="logo"> <img src="images/ctx.png" alt="sample logo" width="120"> KAITIRO APP</div>
  </header>
  	<?php include 'includes/estructura/encabezado.php'; ?>
  <div id="content">
    <?php include 'includes/estructura/Sidebar.php'; ?>
   <section class="mainContent">
     <div class="container">
            <div class="contenidoPrincipal">
                <h2 class="text-center"> Telares </h2>
                <div id="TablaTelares">
                    <table>
                        <?php include 'includes/reportes/TelaresVivoTest.php'; ?>
                   </table>
                </div>
				
      </div>
    </div>
  </div>    
    </section>
  </div>
  	<?php include 'includes/estructura/footer.html'; ?>
</div>

</body>
</html>