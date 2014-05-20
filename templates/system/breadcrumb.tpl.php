<?php if (!empty($breadcrumb)) : ?>
<ol class="breadcrumb">
  <?php print implode(' ' . $breadcrumb_delimiter . ' ', $breadcrumb); ?>
</ol>
<?php endif; ?>
