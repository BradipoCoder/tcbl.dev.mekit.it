<?php
/**
 * Node Company Full
 */
?>

<?php
  hide($content['links']);
  hide($content['list']);
  hide($content['children']);
  hide($content['btm_form']);
  hide($content['webform']);
  hide($content['press']);
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>

  <?php print render($title_prefix); ?>
  <?php print render($title_suffix); ?>

  <div class="node-content"<?php print $content_attributes; ?>>
    <div class="row row-company-head bg-blue">
      <div class="container margin-v-15">
        <div class="row">
          <div class="col-md-4">
            <div class="margin-md-r-1">
              <div class="company-map">
                <?php print render($content['field_img']); ?>
                <?php print render($content['map']); ?>
              </div>
            </div>
          </div>

          <?php if ($has_networks) : ?>
          <div class="col-md-5">
          <?php else : ?>
          <div class="col-md-8"
          <?php endif; ?>

            <div class="margin-md-r-1">
              <h5 class="text-italic margin-b-025">Company: <?php print render($content['field_ref_memb'][0]); ?></h5>
              <h1 class="margin-t-0 margin-b-05 text-dark"><?php print render($content['title_field'][0]); ?></h1>
              <?php print render($content['contacts']); ?>
              <?php print render($content['social']); ?>
            </div>
          </div>

          <?php if ($has_networks) : ?>
            <div class="col-md-3">
              <h5 class="text-italic">Networks</h5>
              <?php print render($content['networks']); ?>
            </div>
          <?php endif; ?>
        </div>

        
      </div>
    </div>

    <?php print render($content['tabs']); ?>

    <div class="row row-company-main">
      <div class="container">
        <div class="company-contents">
          <div id="company-contents--about" class="company-contents__panel open">
            <h3 class="text-normal text-dark margin-t-0 margin-b-1"><?php print render($content['title_field'][0]); ?></h3>
            <div class="row">
              <div class="col-md-6 margin-b-1">
                <div class="margin-md-r-2">
                  <?php print render($content['body']); ?>
                </div>
              </div>
              <div class="col-md-6">
                <?php print render($content['field_images']); ?>
              </div>
            </div>
          </div><!-- about tab -->

          <div id="company-contents--details" class="company-contents__panel">
            <div class="row">
              <div class="col-md-8 margin-b-1">
                <div class="margin-md-r-2">
                  <h3 class="text-normal text-dark margin-t-0 margin-b-1">Key activities</h3>
                  <p class="margin-b-1">Something explaining the Lab key activities</p>
                  <pre class="margin-b-2">Key Activities</pre>

                  <h3 class="text-normal text-dark margin-t-0 margin-b-1">Innovation Approach</h3>
                  <p class="margin-b-1">What does Innovation Approach means</p>
                  <div class="row">
                    <div class="col-sm-7">
                      <?php print render($content['approach']); ?>
                    </div>
                  </div>


                </div>
              </div>
              <div class="col-md-4">

                <?php if ($content['customers']) : ?>
                  <h3 class="text-normal text-dark margin-t-0 margin-b-1">Target Customers</h3>
                  <p class="margin-b-1">What kind of customers</p>
                  <?php print render($content['customers']); ?>
                <?php endif; ?>

                <h3 class="text-normal text-dark margin-b-1">Collaborations</h3>
                <pre>Labs list</pre>

              </div>
            </div>
          </div><!-- details tab -->

          <div id="company-contents--staff" class="company-contents__panel">
            <div class="row">
              <div class="col-md-8 margin-b-1">
                <h3 class="text-normal text-dark margin-t-0 margin-b-1">People</h3>
                <p class="margin-b-1">Something about the Lab Population</p>
                <div class="row">
                  <div class="col-sm-7">
                    <?php print render($content['population']); ?>
                  </div>
                  <div class="col-sm-5">
                    <?php print render($content['staff']); ?>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <h3 class="text-normal text-dark margin-t-0 margin-b-1">Lab Staff</h3>
              </div>
            </div>
          </div><!-- staff tab -->

        </div>
        
      </div>
    </div>

    <div class="row row-company-projects">
      <div class="container">
        <div class="company-projects">
          <h3 class="text-normal text-dark margin-t-0">Lab projects</h3>
        </div>
      </div>
    </div>

  </div>
</div>