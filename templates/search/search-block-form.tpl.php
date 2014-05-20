<div class="container-inline">
  <?php if (empty($variables['form']['#block']->subject)): ?>
    <h2 class="element-invisible"><?php print t('Search form'); ?></h2>
  <?php endif; ?>
</div>
<div class="input-group">
  <?php print $search['search_block_form']; ?>
  <div class="input-group-btn">
    <?php print $search['actions']; ?>
    <?php print $search['hidden']; ?>
  </div>
</div>
