<?php
/**
 * Gmaps Map
 * gmaps.tpl.php
 */
?>
<div class="wrapper-gmpas margin-v-1">
  <iframe width="<?php print $width; ?>" height="<?php print $height; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?hl=<?php print $langcode; ?>&amp;q=<?php print $address; ?>&amp;iwloc=<?php print ($information_bubble ? 'A': 'near'); ?>&amp;z=<?php print $zoom; ?>&amp;t=<?php print $map_type; ?>&amp;output=embed"></iframe>
</div>
