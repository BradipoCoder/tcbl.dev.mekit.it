<?php

/**
 * Profile default | view mode: teaser
 * 
 */

?>
<div class="profile profile-default"<?php print $attributes; ?>>
  
  <a href="<?php print $url; ?>" class="a-block">
    <?php print render($user_profile['avatar']); ?>
    <span class="profile__content">
      <span class="profile__title">
        <strong><?php print render($user_profile['field_firstname'][0]); ?> <?php print render($user_profile['field_lastname'][0]); ?></strong><?php print render($user_profile['type']); ?>
      </span>
      
      <?php if ($show_contact) : ?>
        <span class="small">
          <?php if (isset($user_profile['field_phone'][0]['#markup']) && $user_profile['field_phone'][0]['#markup'] !== '') : ?>
            <?php print render($user_profile['field_phone'][0]); ?><br/>
          <?php endif; ?>
          <?php print render($user_profile['mail']); ?>
        </span>
      <?php endif; ?>
    </span>
  </a>
</div>
