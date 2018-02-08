<?php
/**
 * Error 404: Pagina non trovata
 */
?>

<div class="error-page">
  <h1 class="text-center"><i title="meh-o" class="fa fa-meh-o" aria-hidden="true"></i> Page not found</h1>
  <p class="lead text-center">The page you are looking for does not exist.</p>
  <div class="text-center content margin-b-4">
    <?php $opt['attributes']['class'] = array('btn','btn-default'); ?>
    <p>
      <?php print l('Homepage','node', $opt); ?>
    </p>
  </div>
</div>