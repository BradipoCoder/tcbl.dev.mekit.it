<?php
/**
 * Page
 * page.tpl.php
 */

hide($header_event['address']);
hide($header_event['contact']);

?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="container-fluid container-header">
    <div class="navbar-header">
      <a class="logo navbar-btn pull-left" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
        <?php print render($logo); ?>
      </a>

      <?php if (!empty($site_name)): ?>
        <a class="name navbar-brand txt-brand <?php print $navbar_brand_classes; ?>" href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>">
          <span class="site-title"><?php print $site_name; ?></span>
          <?php if (!empty($site_slogan)) : ?>
            <br/><span class="site-slogan small"><?php print $site_slogan; ?></span>
          <?php endif; ?>
        </a>
      <?php endif; ?>

      <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <?php if (!empty($primary_nav)): ?>
      <div class="navbar-collapse collapse">
        <nav role="navigation">
          <?php if (!empty($primary_nav)): ?>
            <ul class="nav navbar-nav navbar-right">
              <?php print render($primary_nav); ?>
            </ul>
          <?php endif; ?>
          <?php print render($menu_user); ?>
          <?php print render($menu_social); ?>
        </nav>
      </div>
    <?php endif; ?>
  </div>
</header>

<?php if (!empty($page['wide_top'])): ?>
  <div class="wrapper-top container-fluid">
    <div class="row">
      <?php print render($page['wide_top']); ?>
    </div>
  </div>
<?php endif; ?>

<div class="wrapper-content">
  <?php if (!empty($breadcrumb) || $page_title): ?>
    <div class="wrapper-header <?php print $header_class; ?> negative">
      <div class="container">
        <?php print $breadcrumb;?>
        <?php if ($page_title) : ?>
          <h1 class="margin-v-0"><?php print $page_title; ?></h1>
        <?php endif; ?>
        <?php print render($date); ?>
      </div>
    </div><!-- standard breadcrumbs -->
  <?php endif; ?>
  
  <?php if (isset($header_event['date']['item'])): ?>
    <div class="wrapper-header bg-blue">
      <div class="container">
        <?php print render($header_event); ?>

        <div class="row">
          <div class="col-sm-6">
            <?php print render($header_event['address']); ?>
          </div>
          <div class="col-sm-6">
            <?php print render($header_event['contact']); ?>
          </div>
        </div>
      </div>
    </div><!-- header event -->
  <?php endif; ?>
  
  <?php if (isset($archive_menu) && $archive_menu) : ?>
    <div class="wrapper-header bg-blue">
      <div class="container">
        <?php print render($archive_menu); ?>
      </div>
    </div>
  <?php endif; ?>

  <?php print render($page['conference_cover']); ?>

  <div class="main-container <?php print $container_class; ?>">

    <a id="main-content"></a>

    <?php if ($messages) : ?>
      <div class="messages">
        <?php print $messages; ?>
      </div>
    <?php endif; ?>

    <?php if (!$page_with_view): ?>
      <?php // Hide tabs for nodes with view injected in code; see node-page.php ?>
      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($page['help'])): ?>
      <?php print render($page['help']); ?>
    <?php endif; ?>

    <?php if (!empty($action_links)): ?>
      <ul class="action-links"><?php print render($action_links); ?></ul>
    <?php endif; ?>

    <?php print render($page['content']); ?>
  </div>
</div>

<?php if (!empty($page['bottom'])): ?>
  <div class="bottom">
    <div class="container-fluid">
      <?php print render($page['bottom']); ?>
    </div>
  </div>
<?php endif; ?>

<?php if (!empty($page['wide_bottom'])): ?>
  <div class="wrapper-bottom container-fluid">
    <div class="row">
      <?php print render($page['wide_bottom']); ?>
    </div>
  </div>
<?php endif; ?>

<div class="wrapper-footer">
  <footer class="footer container-fluid">
    <?php print render($page['footer']); ?>
    <div class="static-footer">
      <div class="wrapper-footer-img">
        <img src="/sites/tcbl.eu/themes/tcbl/img/eu-flag.jpg" class="img-responsive"/>
      </div>
      <p class="text-center text-italic">
        This project has received funding from the European Union's Horizon 2020 Programme for research, technology development, and innovation under grant Agreement n.646133
      </p>
      <div class="privacy-cookie-links text-center text-italic">
        <a href="/privacy">Privacy policy</a> | <a href="/cookies-policy">Cookies Policy</a>
      </div>
    </div>
  </footer>
</div>
