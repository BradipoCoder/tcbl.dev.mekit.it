<div class="styleguide-page">
  <div class="row">
    <div class="col-md-3">
      <a id="typo"></a>
      <h4 class="margin-t-15 margin-b-2">Typography</h4>
    </div>
    <div class="col-md-8 margin-b-4">
      <?php print render($content['typo']); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <a id="buttons"></a>
      <h4 class="margin-t-15 margin-b-2">Buttons</h4>
    </div>
    <div class="col-md-8 margin-b-4">
      <h1>Colors and active</h1>
      <?php print render($content['buttons'][1]); ?>
      <hr>
      <h1>Dimensions</h1>
      <?php print render($content['buttons'][2]); ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-3">
      <a id="grid"></a>
      <h4 class="margin-t-15 margin-b-2">Grid and spacing</h4>
    </div>
    <div class="col-md-8 margin-b-4">
      <?php print render($content['grid']); ?>
      <hr>
      <?php print render($content['spacing']); ?>
    </div>
  </div>
</div>