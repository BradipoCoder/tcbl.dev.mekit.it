<?php
/**
 * TCBL Front Page
 */
?>

<div class="wrapper-tcbl-front row row-front">
  
  <div class="bg-pink negative">
    <div class="container">
      <h2 class="text-center h1-big margin-v-1">Join the Ecosystem</h2>
    </div>
  </div>
  
  <div class="bg-blue">
    <div class="container">
      <div class="margin-v-2">
        <div class="row">
          <div class="col-sm-6 text-center margin-b-1">
            <h2 class="margin-t-0">Who is TCBL For?</h2>
            <div class="margin-md-h-2">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus iaculis ex non imperdiet.</p>
            </div>
          </div>
          <div class="col-sm-6 text-center margin-b-1">
            <h2 class="margin-t-0">Why should I join TCBL?</h2>
            <div class="margin-md-h-2">
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec cursus iaculis ex non imperdiet.</p>
            </div>
          </div>
        </div>
        
        <?php //if ($show_sign_up) : ?>
          <div class="text-center">
            <a href="https://tcblsso.ilabt.iminds.be/usermanager/user/register" class="btn btn-primary btn-lg" title="Sign up">
              Sign up
            </a>
          </div>
        <?php //endif; ?>
      </div>
    </div>  
  </div>

  <div class="wrapper-front-cms">
    <div class="container">
      <div class="row margin-v-1">
        <div class="col-md-4 margin-b-1">
          <h2 class="h1 h1-front-cms">Latest news</h2>
          <div class="margin-md-r-1">
            <?php print render($content['news']); ?>
          </div>
        </div>
        <div class="col-sm-4">
          <h2 class="h1 h1-front-cms">Upcoming events</h2>
          <?php print render($content['events']); ?>
        </div>
        <div class="col-sm-4">
          <h2 class="h1 h1-front-cms">From the forum</h2>
          <?php print render($content['forum']); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="wrapper-front-banner">
    <div class="container">
      <div class="well"><code>banner</code></div>
    </div>
  </div>

  <div class="wrapper-front-labs">
    <div class="container">
      <div class="front-labs-header text-center">
        <h2 class="h1-big text-uppercase">Labs</h2>
        <p>Lorem ipsum dolor sit amet</p>
      </div>
      <div class="row margin-v-1">
        <div class="col-md-4">
          <div class="well"><code>Lab feed</code></div>
        </div>
        <div class="col-sm-4">
          <div class="well"><code>Lab feed</code></div>
        </div>
        <div class="col-sm-4">
          <div class="well"><code>Lab feed</code></div>
        </div>
      </div>
    </div>
  </div>

  <?php print render($content); ?>
</div>