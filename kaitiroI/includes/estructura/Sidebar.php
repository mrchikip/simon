<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
	<section class="sidebar"> 
      <!-- This adds a sidebar with 1 searchbox,2 menusets, each with 4 links -->
      <input type="text"  id="search" value="search">
      <div id="menubar">
        <nav class="menu">
          <h2><!-- Title for menuset 1 -->REPORTES</h2>
          <hr>
          <ul>
            <!-- List of links under menuset 1 -->
            <li><a href="../../../kaitiro/index.php" title="Kaitiro">Kaitiro</a></li>
            <li><a href="../../../kaitiro/eficiencias.php" title="Eficiencias">Eficiencias</a></li>
            <li><a href="../../../kaitiro/HorasTrabajo.php" title="Horas de Trabajo">Horas De Trabajo</a></li>
            <li class="notimp"><!-- notimp class is applied to remove this link from the tablet and phone views --><a href="#"  title="Link">Link 4</a></li>
          </ul>
        </nav>
        <nav class="menu">
          <h2>GRAFICAS</h2>
          <!-- Title for menuset 2 -->
          <hr>
          <ul>
            <!--List of links under menuset 2 -->
            <li><a href="#" title="Link">Link 1</a></li>
            <li><a href="#" title="Link">Link 2</a></li>
            <li><a href="#" title="Link">Link 3</a></li>
            <li class="notimp"><!-- notimp class is applied to remove this link from the tablet and phone views --><a href="#" title="Link">Link 4</a></li>
          </ul>
        </nav>
      </div>
    </section>
</body>
</html>