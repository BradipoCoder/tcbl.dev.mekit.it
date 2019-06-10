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
    <div id="company-head" class="row row-company-head bg-blue">
      <div class="container margin-v-15">
        <div class="row">

          <?php if ($has_networks) : ?>
          <div class="col-md-5 col-md-push-4">
          <?php else : ?>
          <div class="col-md-8 col-md-push-4">
          <?php endif; ?>
            <div class="margin-md-r-1">
              <h5 class="text-italic margin-b-025">Company: <?php print render($content['field_ref_memb'][0]); ?></h5>
              <h1 class="margin-t-0 margin-b-05 text-dark"><?php print render($content['title_field'][0]); ?></h1>
              <?php print render($content['contacts']); ?>
              <?php print render($content['social']); ?>
            </div>
          </div>

          <?php if ($has_networks) : ?>
            <div class="col-md-3 col-md-push-4">
              <h5 class="text-italic">Networks</h5>
              <?php print render($content['networks']); ?>
            </div>
          <?php endif; ?>

        <div class="col-md-4 col-md-pull-8">
          <div class="margin-md-r-1">
            <div class="company-map">
              <?php print render($content['field_img']); ?>
              <?php print render($content['map']); ?>
            </div>
          </div>
        </div>

      </div>
      </div>
    </div>

    <?php if ($is_lab) :?>
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

                    <?php if ($cw_logo) : ?>
                      <div class="comp">
                        <img src="/sites/tcbl.eu/themes/tcbl/img/cw-logo.jpg" class="img-responsive"/>
                      </div>
                    <?php endif; ?>

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
                    <h3 class="text-normal text-dark margin-t-0 margin-b-1">Innovation Approach</h3>
                    <p class="margin-b-1">The type of lab is defined by how it approaches innovation: design, make, or place.</p>
                    <div class="row">
                      <div class="col-sm-7">
                        <?php print render($content['approach']); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if ($show_colls) : ?>
                  <div class="col-md-4">
                    <h3 class="text-normal text-dark margin-b-1">Collaborations</h3>
                    <?php print render($content['field_ref_labs']); ?>
                    <?php print render($content['field_coll_links']); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div><!-- details tab -->

            <div id="company-contents--staff" class="company-contents__panel">
              <div class="row">
                <div class="col-md-6 margin-b-1">
                  <h3 class="text-normal text-dark margin-t-0 margin-b-1">People</h3>
                  <p class="margin-b-1">Description of who can be found in the lab over one month.</p>
                  <?php print render($content['population']); ?>
                </div>

                <?php if (isset($content['field_ref_user'][0])) : ?>
                  <div class="col-md-6">
                    <div class="margin-b-1">
                      <h3 class="text-normal text-dark margin-t-0 margin-b-1">Lab Staff</h3>
                      <?php print render($content['field_ref_user']); ?>
                    </div>
                    <?php if ($show_workers_icons) : ?>
                    <p class="margin-b-1">How many people work in the lab (staff or volunteers)</p>
                      <?php print render($content['staff']); ?>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>

              </div>
            </div><!-- staff tab -->

            <div id="company-contents--ka" class="company-contents__panel">
              <div class="row">
                <div class="col-md-8 margin-b-1">
                  <div class="margin-md-r-1">
                    <h3 class="text-normal text-dark margin-t-0 margin-b-1">Key activities</h3>
                    <p class="margin-b-1">This lab works in the following activities</p>
                    <?php print render($content['kas']); ?>
                  </div>
                </div>
                <?php if ($content['customers']) : ?>
                  <div class="col-md-4">
                    <h3 class="text-normal text-dark margin-t-0 margin-b-1">Target publics</h3>
                    <p class="margin-b-1">Who the lab wishes to engage</p>
                    <?php print render($content['customers']); ?>
                  </div>
                <?php endif; ?>
              </div>
            </div><!-- ka tab -->
            
          </div>    
        </div>
      </div>

      <?php if ($content['projects']) : ?>
        <div class="row row-company-projects">
          <div class="container">
            <div class="company-projects">
              <h3 class="text-normal text-dark margin-t-0 margin-b-05">Lab projects</h3>
              <div class="margin-b-1">
                <a href="<?php print url('node/516'); ?>" title="All projects" class="small"><i class="fa fa-angle-right"></i> All projects</a>
              </div>

              <div class="row row-projects">
                <?php print render($content['projects']); ?>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?> 
    <?php else : ?>
      <div class="row row-company-main">
        <div class="container">
          <h3 class="text-normal text-dark margin-b-1"><?php print render($content['title_field'][0]); ?></h3>
            <div class="row">
              <div class="col-md-6 margin-b-1">
                <div class="margin-md-r-2">
                  <?php if ($is_startup) :?>
                    <div class="company-startup small">
                      <?php print render($content['field_su_year']); ?>
                      <?php print render($content['field_ref_su_ia']); ?>
                      <?php print render($content['field_ref_su_m']); ?>
                      <hr>
                    </div>
                  <?php endif; ?>
                  <?php print render($content['body']); ?>
                </div>
              </div>
              <div class="col-md-6">
                <?php print render($content['field_images']); ?>
              </div>
            </div>
        </div>
      </div>
    <?php endif; ?>

  </div>
</div>