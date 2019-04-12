<?php
/**
 * Main Labs page
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['field_image']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>

    <div class="row row-labs-head">
      <div class="parallax-w" data-bleed="1" data-parallax="scroll" data-image-src="<?php print $img_url; ?>" data-position-y="center">
        <div class="wrapper-over-parallax">
          <div class="over-parallax-dark">
            <div class="container">
              <div class="labs-head-content negative">
                <div class="lead">
                  <?php print render($content['body']); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row row-labs-cta bg-blue">
      <div class="container margin-v-2">
        <div class="row">
          <div class="col-md-6">
            <h3 class="margin-t-0 text-normal text-dark">Who are Labs for?</h3>
            <p>
              Learn more about TCBL labs and how they can help you as a company, independent designer, student or citizen.
            </p>
            <a href="#" class="btn btn-default">Learn more</a>
          </div>
          <div class="col-md-6">
            <h3 class="margin-t-0 text-normal">Sign up as a Lab</h3>
            <p>
              Information for lab managers wishing to join TCBL Labs and enter into a world of collaborative opportunities.
            </p>
            <a href="#" class="btn btn-primary">Join the network</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row row-labs-archive">
      <div class="container margin-v-2">
        <h1 class="margin-t-0 text-dark">Find a textile lab near you</h1>
        <?php print render($content); ?>
      </div>
    </div>

  </div>
</div>