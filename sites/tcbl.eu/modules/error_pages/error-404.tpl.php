<?php
/**
 * Error 404: Pagina non trovata
 */
?>

<div class="error-page">
  <h1 class="text-center"><i title="meh-o" class="fa fa-meh-o" aria-hidden="true"></i> Pagina non trovata</h1>
  <p class="lead text-center">La pagina che stai cercando non esiste</p>
  <div class="text-center content margin-b-4">
    <?php $opt['attributes']['class'] = array('btn','btn-default'); ?>
    <p>
      <?php print l('Torna alla homepage','node', $opt); ?>
    </p>
  </div>
</div>