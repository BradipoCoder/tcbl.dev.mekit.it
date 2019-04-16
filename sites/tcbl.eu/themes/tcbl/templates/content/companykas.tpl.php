<?php
/**
 * Company Key Activities
 * companykas.tpl.php
 */
?>


<ul id="company-kas" class="company-kas">
  <?php foreach ($items as $key => $item) : ?>
    <li class="company-kas__item company-kas__item--<?php print $item['tid']; ?>">
      <span class="kas-circle">
        <?php print $item['letter']; ?>
      </span>
      <h5 class="margin-v-0"><?php print $item['title']; ?></h5>
    </li>
  <?php endforeach; ?>
</ul>
