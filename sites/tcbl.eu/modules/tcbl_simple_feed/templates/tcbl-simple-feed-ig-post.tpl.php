<?php if ($post['media_url']) : ?>
  <div class="socialfeed-item socialfeed-item--instagram">
    <?php if ($post['post_url']) : ?>
      <a href="<?php print $post['post_url']; ?>" target="_blank" class="a-block">
        <span class="socialfeed-frame" style="background: url(<?php print $post['media_url']; ?>);">
          <i class="fa fa-instagram fa-fw"></i>
        </span>
      </a>
    <?php else : ?>
      <div class="socialfeed-frame" style="background: url(<?php print $post['media_url']; ?>);">
        <i class="fa fa-instagram fa-fw"></i>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>
