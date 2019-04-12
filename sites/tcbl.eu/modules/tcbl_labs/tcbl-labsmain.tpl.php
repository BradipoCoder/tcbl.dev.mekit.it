<div class="labsmain">
  <div class="labsmain__filters">
    <div class="row">
      <div class="col-md-6">
        <div class="input-group">
          <input id="labsmain-search" class="form-control" placeholder="Search by Company"/>
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>
      <div class="col-md-3">
        <select name="country" class="form-control">
          <option value=""></option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="activities" class="form-control">
          <option value=""></option>
        </select>
      </div>
    </div>
  </div>

  <div class="labsmain__results">
    <div class="row">
      <div class="col-md-6">
        <?php print render($content['nodes']); ?>
      </div>
      <div class="col-md-6">
        <?php print render($content['map']); ?>
      </div>
    </div>
  </div>

</div>