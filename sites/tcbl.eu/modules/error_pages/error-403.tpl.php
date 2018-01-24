<?php
/**
 * Error 403: Accesso negato
 */
?>

<div class="error-page">
  <h1 class="text-center"><i title="meh-o" class="fa fa-ban" aria-hidden="true"></i> Accesso negato</h1>
  <p class="lead text-center">Sembra che tu non sia autorizzato a visualizzare questa pagina.</p>
  <div class="text-center content margin-b-4">
    <p>
      <?php $opt['attributes']['class'] = array('btn','btn-primary'); ?>
      <?php print l('Effettua il log-in','user', $opt); ?>
      <?php $opt2['attributes']['class'] = array('btn','btn-default'); ?>
      <?php print l('Torna alla homepage','node', $opt2); ?>
    </p>
  </div>
</div>