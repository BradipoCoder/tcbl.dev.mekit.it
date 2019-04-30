<?php
/**
 * Company Key Activities
 * companykas.tpl.php
 */
?>


<ul id="company-kas" class="company-kas">
  <?php foreach ($items as $key => $item) : ?>
    <li id="company-kas-item-<?php print $item['tid']; ?>" class="company-kas__item company-kas__item--<?php print $item['tid']; ?> <?php print $item['class']; ?>">
      <div id="company-kas-head-<?php print $item['tid']; ?>" class="company-kas__head" data-tid="<?php print $item['tid']; ?>">
        <span class="kas-circle">
          <?php print $item['letter']; ?>
        </span>
        <h5 class="margin-v-0"><?php print $item['title']; ?></h5>
        <span class="toggle">
          <i class="fa fa-angle-down"></i>
        </span>
      </div>
      <div id="company-kas-content-<?php print $item['tid']; ?>" class="company-kas__content">
        <pre>content</pre>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
