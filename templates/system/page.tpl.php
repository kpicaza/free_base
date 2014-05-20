<div id="skip-link"></div>
<!-- @todo crear configuracion para menú $fixed_navbar -->
<div id="navigation" class="navbar navbar-default<?php print ' navbar-fixed-top'; //$fixed_navbar ? ' ' . $fixed_navbar : '';                        ?>" role="navigation">
  <div class="container col-md-12">
    <!-- @todo Process navigation links -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#free-navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php print $base_path; ?>">

        <?php if ($logo) : ?>
          <img src="<?php print $logo; ?>" width="30px" height="30px"/>
        <?php endif; ?>

        <?php if ($site_name) : ?>
          <span class="lead"><?php print $site_name ?></span>
        <?php endif; ?>

      </a>
    </div>
    <div class="collapse navbar-collapse" id="free-navbar-collapse">
      <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu', 'class' => array('menu', 'nav', 'navbar-nav')))); ?>
      <?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('menu', 'nav', 'navbar-nav', 'pull-right')))); ?>
      <?php print render($page['navigation']); ?>
    </div>  
  </div>
</div>

<div id="page" class="container"> 
  <div class="container region region-page-top row">
    <div id="header" class="col-md-12">

      <?php if ($site_slogan) : ?>
        <div class="site-slogan page-header">
          <h1><?php print $site_slogan; ?></h1>
        </div>
      <?php endif; ?>

      <?php print render($page['header']); ?>
      <?php print render($page['branding']); ?>

      <!-- @todo Create breadcrumbs system @see template.php -->
      <?php print render($breadcrumb); ?>
    </div>
  </div>

  <div id="<?php print $classes; ?>"> 
    <?php print render($page['hero']); ?>

    <div id="main-wrapper">
      <div id="main">

        <!-- Print First sidebar. -->
        <?php if (!empty($page['sidebar_first'])) : ?>
          <div id="sidebar-first" class="panel panel-default col-md-3">
            <?php print render($page['sidebar_first']); ?>
          </div>
        <?php endif; ?>

        <!-- Print main content. -->
        <?php if (!empty($page['sidebar_first']) && (!empty($page['sidebar_second']) || !empty($page['featured']))) : ?>
          <div id="content" class="col-md-6">
            <?php
          elseif ((!empty($page['sidebar_first']) && (empty($page['sidebar_second']) || empty($page['featured']))) ||
              (empty($page['sidebar_first']) && (!empty($page['sidebar_second']) || !empty($page['featured'])))) :
            ?>
            <div id="content" class="col-md-9">
            <?php else : ?>
              <div id="content" class="col-md-12">
              <?php endif; ?>
              <?php print render($page['content']); ?>
            </div>

            <!-- Print Second sidebar. -->
            <?php if (!empty($page['sidebar_second'])) : ?>
              <div id="sidebar-second" class="panel panel-default col-md-3">
                <?php print render($page['sidebar_second']); ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="footer" class="container-fluid">
    <div class="container">
      <?php print render($page['footer']); ?>
    </div>
  </div>

  <?php if ($show_messages) : ?>
    <a id="messagesOp" class="element-invisible" data-toggle="modal" data-target="#messagesModal">
      <?php print t('Messages'); ?>
    </a>
    <?php print render($messages); ?>

  <?php endif; ?>

