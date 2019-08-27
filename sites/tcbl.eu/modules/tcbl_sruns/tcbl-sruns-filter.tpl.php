<div class="row row-runs">
  <div id="sruns" class="sruns">
    <div id="sruns-filter" class="sruns-filter">
      <ul class="ul-topics">
        <?php foreach ($data['progress']['topics'] as $tid => $topic) : ?>
          <li id="li-topic-<?php print $tid; ?>" class="li-topic <?php $topic['on'] ? print 'open' : false ?>" data-tid="<?php print $tid; ?>">
            <?php print $topic['name']; ?>
            <i class="fa fa-check-circle i-check"></i>
            <i class="fa fa-ban i-skip"></i>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div id="sruns-content" class="sruns-content">
      <div id="sruns-questions" class="sruns-questions">
        <?php foreach ($data['progress']['questions'] as $tid => $question) : ?>
          <div id="question-<?php print $tid; ?>" class="question <?php $question['on'] ? false : print 'hide' ?>" data-tid="<?php print $tid; ?>">
            <?php print render($question['build']); ?>

            <div class="wrapper-bts">
              <span href="#" data-tid="<?php print $tid; ?>" class="bts bts--flat bts-yes">Yes</span>
              <span href="#" data-tid="<?php print $tid; ?>" class="bts bts--out bts-no">No</span>
              <span href="#" data-tid="<?php print $tid; ?>" class="bts bts--out bts--default bts-skip">Not applicable</span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div id="sruns-results" class="sruns-results">
        <hr>
        <?php foreach ($data['progress']['results'] as $tid => $result) : ?>
          <div id="result-<?php print $tid; ?>" class="results hide" data-tid="<?php print $tid; ?>">
            <h3 class="margin-v-2 text-dark">Here are resources that may help you</h3>
            <div class="row wrapper-sameh">
              <?php print render($result['content']); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</div>