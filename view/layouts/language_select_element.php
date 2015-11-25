<?php
// file: view/layouts/language_select_element.php
?>

<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle"
          data-toggle="dropdown">
    <?= i18n("Escoger idioma")?><span class="caret"></span>
  </button>
 
  <ul class="dropdown-menu" role="menu">
    <li><a href="index.php?controller=language&amp;action=change&amp;lang=es">
	<?= i18n("Español") ?>
	</a></li>
    <li><a href="index.php?controller=language&amp;action=change&amp;lang=en">
	<?= i18n("Ingl&eacute;s") ?>
	</a></li>
	<li><a href="index.php?controller=language&amp;action=change&amp;lang=ga">
	<?= i18n("Gallego") ?>
	</a></li>
  </ul>
</div>