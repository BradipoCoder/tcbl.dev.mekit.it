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
      <?php if (!user_is_logged_in()) : ?>
        <?php $opt['attributes']['class'] = array('btn','btn-primary'); ?>
        <?php print l(t('Log in'), 'user/gluuSSO', $opt); ?>
      <?php endif; ?>
      <?php $opt2['attributes']['class'] = array('btn','btn-default'); ?>
      <?php print l(t('Homepage'),'node', $opt2); ?>
    </p>
  </div>
</div>