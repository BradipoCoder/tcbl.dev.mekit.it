<?php
/**
 * Company tabs
 * companytabs.tpl.php
 */
?>
<div class="row row-company-tabs">
  <div class="container">
    <ul id="company-tabs" class="company-tabs">
      <?php foreach ($items as $key => $item) : ?>
        <li class="company-tabs__item">
          <a href="#<?php print $key; ?>" id="company-tabs-a-<?php print $key; ?>" data-id="<?php print $key; ?>" class="company-tabs__a <?php print $item['class'] ;?>"><?php print $item['title']; ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
