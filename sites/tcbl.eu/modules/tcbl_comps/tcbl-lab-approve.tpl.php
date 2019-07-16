<div class="tcbl-lab-approve">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <?php if ($status == 'check') : ?>
            <h2>You are validating the Lab <?php print render($content['name']); ?></h2>
            <p>This action cannot be undone, click on the validate button to confirm.</p>
          <?php endif; ?>

          <?php if ($status == 'confirm') : ?>
            <h2>Thanks</h2>
            <p>
              The Lab <strong><?php print render($content['name']); ?></strong> has received your approval.
            </p>
          <?php endif; ?>
          <?php print render($content['btns']); ?>
        </div>
      </div>
    </div>
  </div>
</div>