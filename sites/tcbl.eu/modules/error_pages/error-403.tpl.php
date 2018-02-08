<?php
/**
 * Error 403: Accesso negato
 */
?>

<div class="error-page">
  <h1 class="text-center"><i title="meh-o" class="fa fa-ban" aria-hidden="true"></i> Access denied</h1>
  <p class="lead text-center">You are not authorized to view this page.</p>
  <div class="text-center content margin-b-4">
    <p>
      <?php $opt['attributes']['class'] = array('btn','btn-primary'); ?>
      <?php print l('Effettua il log-in','user', $opt); ?>
      <?php $opt2['attributes']['class'] = array('btn','btn-default'); ?>
      <?php print l('Torna alla homepage','node', $opt2); ?>
    </p>
  </div>
</div>