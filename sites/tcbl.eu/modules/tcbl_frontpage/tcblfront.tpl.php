<?php
/**
 * TCBL Front Page
 */
/** @type array $content */
/** @type array $tcbl_feeds */
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
              <p>Anyone who wants to transform the textile and clothing industry: sector businesses, researchers and explorers, service providers, and experts facilitating knowledge exchange and innovation.</p>
            </div>
          </div>
          <div class="col-sm-6 text-center margin-b-1">
            <h2 class="margin-t-0">Why should I join TCBL?</h2>
            <div class="margin-md-h-2">
              <p>Become part of a value-based community where different types of organisations are working together to create a low-risk environment for business model innovation.</p>
            </div>
          </div>
        </div>

        <?php //if ($show_sign_up) : ?>
        <div class="text-center">
          <a href="https://tcblsso.ilabt.iminds.be/usermanager/user/register"
             class="btn btn-primary btn-lg" title="Sign up">
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
        <?php print render($tcbl_feeds["labs"]); ?>
      </div>
    </div>
  </div>

  <div class="wrapper-front-business-pilots">
    <div class="container">
      <div class="well"><code>Business Pilots</code></div>
    </div>
  </div>

  <div class="wrapper-front-feed-zine">
    <div class="container">
      <div class="front-feed-header text-center">
        <h2 class="h1-big text-uppercase">TCBL_ZINE</h2>
        <p>Storytelling, case studies, research and more on the world of textile and clothing in Europe</p>
      </div>
      <div class="row margin-v-1">
        <?php print render($tcbl_feeds["zine"]); ?>
      </div>
    </div>
  </div>

  <div class="wrapper-front-feed-social">
    <div class="container">
      <div class="row margin-v-1">
        <?php print render($tcbl_feeds["social"]); ?>
      </div>
    </div>
  </div>

  <?php print render($content); ?>
</div>