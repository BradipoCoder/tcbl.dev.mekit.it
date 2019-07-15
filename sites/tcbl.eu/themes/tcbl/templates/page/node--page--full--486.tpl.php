<?php
/**
 * Directory Main Page
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['field_image']);
  hide($content['body']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>

    <div class="row">
      <div class="parallax-w" data-bleed="1" data-parallax="scroll" data-image-src="<?php print $img_url; ?>" data-position-y="center">
        <div class="wrapper-over-parallax">
          <div class="over-parallax-dark">
            <div class="container">
              <div class="directory-head-content negative">
                <div class="lead">
                  <?php print render($content['body'][0]); ?>
                </div>
                <?php if ($show_sign_up) : ?>
                  <a href="https://weeave.tcbl.eu/usermanager/user/register"
                     class="btn btn-primary btn-lg margin-t-1" title="Sign up">
                    Join TCBL
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row row-directory-head">
      <div class="container">
        <div class="directory-numbers">
        <?php print render($content['numbers']); ?> 
        </div>
      </div>
    </div>

    <div id="row-directory-archive" class="row row-directory-archive">
      <div class="container margin-v-2">
        <h1 class="margin-t-0 margin-b-0 text-dark">Explore who already joined the TCBL Network</h1>
        <?php print render($content); ?>
      </div>
    </div>

  </div>
</div>