<div class="row row-sruns">
  <div id="sruns" class="sruns">
    <div id="sruns-filter" class="sruns-filter">
      <ul id="ul-topics" class="ul-topics">
        <?php foreach ($data['progress']['topics'] as $tid => $topic) : ?>
          <li id="li-topic-<?php print $tid; ?>" class="li-topic <?php $topic['on'] ? print 'open' : false ?>" data-tid="<?php print $tid; ?>">
            <?php print $topic['name']; ?>
            <i class="fa fa-check-circle i-yes"></i>
            <i class="fa fa-close i-no"></i>
            <i class="fa fa-ban i-skip"></i>
          </li>
        <?php endforeach; ?>
      </ul>
      <div id="sruns-progress" class="sruns-progress">
        <div class="s-progress"></div>
      </div>
      <div id="sruns-next" class="sruns-next">
        <a href="#" class="btn btn-default disabled margin-b-05">Next</a>
        <p class="help small">Complete all the answers to proceed</p>
      </div>
    </div>
    <div id="sruns-content" class="sruns-content">
      <div id="sruns-questions" class="sruns-questions">
        <?php foreach ($data['progress']['questions'] as $tid => $question) : ?>
          <div id="question-<?php print $tid; ?>" class="question <?php $question['on'] ? false : print 'hide' ?>" data-tid="<?php print $tid; ?>">
            <?php print render($question['build']); ?>

            <div id="wrapper-bts-<?php print $tid; ?>" class="wrapper-bts">
              <span 
                href="#"
                id="bts-yes-<?php print $tid; ?>"
                data-tid="<?php print $tid; ?>"
                class="bts bts--flat bts-yes">
                Yes <i class="fa fa-check i-check"></i>
              </span>
              <span
                href="#"
                id="bts-no-<?php print $tid; ?>"
                data-tid="<?php print $tid; ?>"
                class="bts bts--out bts-no">
                No <i class="fa fa-check i-check"></i>
              </span>
              <span
                href="#"
                id="bts-skip-<?php print $tid; ?>"
                data-tid="<?php print $tid; ?>"
                class="bts bts--out bts--default bts-skip">
                Not applicable <i class="fa fa-check i-check"></i>
              </span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div id="sruns-results" class="sruns-results">
        <hr>
        <?php foreach ($data['progress']['results'] as $tid => $result) : ?>
          <div id="result-<?php print $tid; ?>" class="results hide" data-tid="<?php print $tid; ?>">
            <h3 class="margin-b-1 text-dark">Here are resources that may help you</h3>
            <div class="row wrapper-sameh">
              <?php print render($result['content']); ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</div>