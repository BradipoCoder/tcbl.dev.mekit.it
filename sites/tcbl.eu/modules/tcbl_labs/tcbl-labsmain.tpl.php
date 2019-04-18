<div id="labsmain" class="labsmain">
  <div id="labs-filters" class="labsmain__filters">
    <div class="row">
      <div class="col-md-6">
        <div class="input-group">
          <input id="labs-search" class="form-control" placeholder="Search by Company"/>
          <span class="input-group-btn">
            <button id="search-button" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>
      <div class="col-md-3">
        <?php if ($content['filters']['country']) : ?>
          <select id="filter-country" name="country" class="form-control labs-select">
            <option value="all">- All Countries -</option>
            <?php foreach ($content['filters']['country'] as $c => $item) : ?>
              <?php if ($item['selected']) : ?>
                <option selected="true" value="<?php print $c; ?>"><?php print $item['title']; ?></option>
              <?php else : ?>
                <option value="<?php print $c; ?>"><?php print $item['title']; ?></option>
              <?php endif; ?>
            <?php endforeach ?>
          </select>
        <?php endif ?>
      </div>
      <div class="col-md-3">
        <select id="filter-kas" name="kas" class="form-control labs-select">
          <?php if ($content['filters']['kas']) : ?>
            <option value="all">- All Activities -</option>

            <?php foreach ($content['filters']['kas'] as $k => $item) : ?>
              <?php if ($item['selected']) : ?>
                <option selected="true" value="<?php print $k; ?>"><?php print $item['title']; ?></option>
              <?php else : ?>
                <option value="<?php print $k; ?>"><?php print $item['title']; ?></option>  
              <?php endif; ?>
            <?php endforeach ?>  

          <?php endif; ?>
        </select>
      </div>
    </div>
    <span class="loader"></span>
  </div>

  <div class="labsmain__results">
    <div class="row">
      <div class="col-md-6">
        <div id="labs-results">
          
        </div>
        <div id="labs-pagination" class="labs-pagination"></div>
      </div>
      <div class="col-md-6">
        <?php print render($content['map']); ?>
      </div>
    </div>
  </div>

</div>