<div id="node-<?php print $node->nid; ?>" class="<?php print !$page ? 'list-group-item ' . $classes : $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php if ($page) : ?>
    <div class="panel panel-default">
      <div class="panel-body">
  <?php endif; ?>
        
      <?php print $user_picture; ?>
      <?php print render($title_prefix); ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php print render($title_suffix); ?>
      
      <?php if ($display_submitted): ?>
        <div class="submitted">
          <?php print t('Submitted by !username on !datetime', array('!username' => $name, '!datetime' => $date)); ?>
        </div>
      <?php endif; ?>
      
      <div class="content"<?php print $content_attributes; ?>>
        <?php
        // We hide the comments and links now so that we can render them later.
        hide($content['comments']);
        hide($content['links']);
        print render($content);
        ?>
      </div>
      
  <?php if ($page) : ?>
      </div>
    </div>
  <?php endif; ?>
  
  <?php print render($content['links']); ?>
  <?php print render($content['comments']); ?>
</div>
