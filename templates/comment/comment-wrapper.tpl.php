<div id="comments" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if ($content['comments'] && $node->type != 'forum'): ?>
    <?php print render($title_prefix); ?>
    <h3 class="title"><?php print t('Comments'); ?></h3>
    <?php print render($title_suffix); ?>
  <?php endif; ?>
    
  <!-- @todo display login form if not logged in.
       @todo submit form via ajax. -->
  <?php if ($content['comment_form']): ?>
    <!-- Button trigger modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#commentModal">
      <?php print t('Leave a comment'); ?>
    </button>
    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">    
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h2 class="title comment-form"><?php print t('Add new comment'); ?></h2>
          </div>
          <div class="modal-body">
            <!-- @todo add button classes to form submit:
                 @todo add close button.
                  <button type="button" class="btn btn-primary">. -->
            <?php print render($content['comment_form']); ?>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php print render($content['comments']); ?>
</div>
