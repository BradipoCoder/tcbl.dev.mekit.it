<div class="wrapper-dashboard">
  <?php print render($content['title']) ; ?>
  <hr>
  <div class="row">
    <?php if ($content['projects']) : ?>
      <div class="col-md-6">
    <?php else : ?>
      <div class="col-md-12">   
    <?php endif; ?>
      <?php print render($content['comps']) ; ?>  
    </div>
    
    <?php if ($content['projects']) : ?>
      <div class="col-md-6">
        <?php print render($content['projects']) ; ?>  
      </div>
    <?php endif; ?>
  </div>

  <?php if ($content['pending']) : ?>
    <h3 class="text-normal text-dark">These Labs are waiting for your approval</h3>
    <?php print render($content['pending']) ; ?> 
    <hr>
  <?php endif; ?>
</div>