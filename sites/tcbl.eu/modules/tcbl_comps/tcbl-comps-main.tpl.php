<div id="compsmain" class="compsmain">
  <div id="comps-filters" class="compsmain__filters">

    <div class="comps-filters__tools">
      <a id="toggle-map" class="btn toggle-map on">
        <i class="fa fa-toggle-on"></i> Show map
      </a>
      <a id="reset-filters" class="btn reset-filters">
        <i class="fa fa-refresh"></i> Reset filters
      </a>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="input-group">
          <input id="comps-search" class="form-control" placeholder="Search by Company"/>
          <span class="input-group-btn">
            <button id="search-button" class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
          </span>
        </div>
      </div>
      <div class="col-md-3">
        <?php if ($content['filters']['country']) : ?>
          <select id="filter-country" name="country" class="form-control comps-select">
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
        <?php if ($aid == 'labs') : ?>
          <select id="filter-kas" name="kas" class="form-control comps-select">
            <?php if ($content['filters']['kas']) : ?>
              <option value="all">- All activities -</option>

              <?php foreach ($content['filters']['kas'] as $k => $item) : ?>
                <?php if ($item['selected']) : ?>
                  <option selected="true" value="<?php print $k; ?>"><?php print $item['title']; ?></option>
                <?php else : ?>
                  <option value="<?php print $k; ?>"><?php print $item['title']; ?></option>  
                <?php endif; ?>
              <?php endforeach ?>  

            <?php endif; ?>
          </select>
        <?php endif; ?>

        <?php if ($aid == 'directory') : ?>
          <select id="filter-memb" name="memb" class="form-control comps-select">
            <?php if ($content['filters']['memb']) : ?>
              <option value="all">- All member types -</option>

              <?php foreach ($content['filters']['memb'] as $k => $item) : ?>
                <?php if ($item['selected']) : ?>
                  <option selected="true" value="<?php print $k; ?>"><?php print $item['title']; ?></option>
                <?php else : ?>
                  <option value="<?php print $k; ?>"><?php print $item['title']; ?></option>  
                <?php endif; ?>
              <?php endforeach ?>  

            <?php endif; ?>
          </select>
        <?php endif; ?>
      </div>
    </div>

    <span class="loader"></span>
  </div>

  <div id="compsmain-results" class="compsmain__results">
    <div class="compsmain__list">
      <div id="comps-results" class="comps-results"></div>
      <div id="comps-pagination" class="comps-pagination"></div>
    </div>
    <div class="compsmain__map">
      <?php print render($content['map']); ?>
    </div>
  </div>

</div>