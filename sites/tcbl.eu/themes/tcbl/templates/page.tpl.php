<?php
/**
 * Page
 * page.tpl.php
 */
?>

<header id="navbar" role="banner" class="<?php print $navbar_classes; ?>">
  <div class="container container-header">
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
  <div class="main-container <?php print $container_class; ?>">  
    <?php if (!empty($breadcrumb)): print $breadcrumb; endif;?>
    <a id="main-content"></a>
    
    <?php if ($messages) : ?>
      <div class="messages">
        <?php print $messages; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($tabs)): ?>
      <?php print render($tabs); ?>
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
    <div class="container">
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
  <footer class="footer container-fluid negative">
    <?php print render($page['footer']); ?>
  </footer>
</div>
