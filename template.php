<?php

/**
 * Returns HTML for a breadcrumb trail.
 * 
 * @param $variables
 *  An associative array containing:
 *  - breadcrumb: An array countaining the breadcrumb links.
 */
/*
  function grayscale_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
  // Provide a navigational heading to give context for breadcrumb links to
  // screen-reader users. Make the heading invsible with .element-invisible.
  $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

  $output .= '<ol class="breadcrumb">' . implode(' * ', $breadcrumb) . '</ol>';
  return $output;
  }
  }
 */

/**
 * Implements hook_preprocess_page().
 */
function freeee_preprocess_page(&$variables) {
}

/**
 * Implements hook_preprocess_hook().
 * 
 * Variables we set here will be available to the breadcrumb template file.
 */
function freeee_preprocess_breadcrumb(&$variables) {
  $variables['breadcrumb_delimiter'] = '/';
}

/**
 * Implements hook_preprocess_block().
 */
function freeee_preprocess_block(&$variables) {
  // Use a bare template for the page's main content.
  if ($variables['block_html_id'] == 'block-system-main') {
    $variables['theme_hook_suggestions'][] = 'block__no_wrapper';
  }
  $variables['title_attributes_array']['class'][] = 'block-title';
}

/**
 * Implements template_preprocess_search_block_form().
 */
function freeee_preprocess_search_block_form(&$variables) {
  $variables['search']['search_block_form'] = '<label class="element-invisible" for="edit-search-block-form--2">' . t('Search') . '</label>'
      . '<input title="' . t('Enter the terms you wish to search for.') . '" class="form-control form-text" type="text" id="edit-search-block-form--2" name="search_block_form" value="" size="15" maxlength="128" />';
}

/**
 * Implements hook_process_block().
 */
function freeee_process_block(&$variables) {
  // Drupal 7 should use a $title variable instead of $block->subject.
  $variables['title'] = $variables['block']->subject;
}

/**
 * Implements template_form_alter().
 * 
 * @param type $form
 * @param type $form_state
 * @param type $form_id
 */
function freeee_form_alter(&$form, &$form_state, $form_id) {
  $form['actions']['submit']['#attributes']['class'][] = 'btn btn-primary';
  $form[$form_id]['#attributes']['class'][] = 'form-control';
  if (substr($form_id, 0, 8) == 'comment_') {
    $form['actions']['#attributes']['class'][] = 'modal-footer';
    $form['actions']['preview']['#attributes']['class'][] = 'btn btn-default';
  }
}

/**
 * Implements template_form_formID_alter().
 * 
 * @param type $form
 * @param type $form_state
 * @param type $action
 * @param type $keys
 * @param type $module
 * @param type $prompt
 */
function freeee_form_search_block_form_alter(&$form, &$form_state, $action = '', $keys = '', $module = NULL, $prompt = NULL) {
  //$form['#theme'] = 'search_form_theme';
  $form['#attributes']['class'] = array('control-group');
  $form['actions']['submit']['#attributes']['class'][] = 'btn btn-default';
}

/**
 * Implements hook_theme().
 */
/*
  function freeee_theme($existing, $type, $theme, $path) {
  return array(
  'search_form_theme' => array(
  'render element' => 'form',
  'template' => 'templates/search/search-form-theme',
  ),
  );
  }
 */

/**
 * Overrides theme_menu_link().
 */
function freeee_menu_link(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if ($element['#below']) {
    // Prevent dropdown functions from being added to management menu so it
    // does not affect the navbar module.
    if (($element['#original_link']['menu_name'] == 'management') && (module_exists('navbar'))) {
      $sub_menu = drupal_render($element['#below']);
    }
    elseif ((!empty($element['#original_link']['depth'])) && ($element['#original_link']['depth'] == 1)) {
      // Add our own wrapper.
      unset($element['#below']['#theme_wrappers']);
      $sub_menu = '<ul class="dropdown-menu">' . drupal_render($element['#below']) . '</ul>';
      // Generate as standard dropdown.
      $element['#title'] .= ' <span class="caret"></span>';
      $element['#attributes']['class'][] = 'dropdown';
      $element['#localized_options']['html'] = TRUE;

      // Set dropdown trigger element to # to prevent inadvertant page loading
      // when a submenu link is clicked.
      $element['#localized_options']['attributes']['data-target'] = '#';
      $element['#localized_options']['attributes']['class'][] = 'dropdown-toggle';
      $element['#localized_options']['attributes']['data-toggle'] = 'dropdown';
    }
  }
  // On primary navigation menu, class 'active' is not set on active menu item.
  // @see https://drupal.org/node/1896674
  if (($element['#href'] == $_GET['q'] || ($element['#href'] == '<front>' && drupal_is_front_page())) && (empty($element['#localized_options']['language']))) {
    $element['#attributes']['class'][] = 'active';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Overrides theme_menu_tree().
 */
function freeee_menu_tree(&$variables) {
  return '<ul class="menu nav">' . $variables['tree'] . '</ul>';
}

/**
 * Overrides theme_menu_local_action().
 */
function freeee_menu_local_action($variables) {
  $link = $variables['element']['#link'];

  $options = isset($link['localized_options']) ? $link['localized_options'] : array();

  // If the title is not HTML, sanitize it.
  if (empty($options['html'])) {
    $link['title'] = check_plain($link['title']);
  }

  $icon = _freeee_iconize_button($link['title']);

  // Format the action link.
  $output = '<li>';
  if (isset($link['href'])) {
    // Turn link into a mini-button and colorize based on title.
    if ($class = _freeee_colorize_button($link['title'])) {
      if (!isset($options['attributes']['class'])) {
        $options['attributes']['class'] = array();
      }
      $string = is_string($options['attributes']['class']);
      if ($string) {
        $options['attributes']['class'] = explode(' ', $options['attributes']['class']);
      }
      $options['attributes']['class'][] = 'btn';
      $options['attributes']['class'][] = 'btn-xs';
      $options['attributes']['class'][] = $class;
      if ($string) {
        $options['attributes']['class'] = implode(' ', $options['attributes']['class']);
      }
    }
    // Force HTML so we can add the icon rendering element.
    $options['html'] = TRUE;
    $output .= l($icon . $link['title'], $link['href'], $options);
  }
  else {
    $output .= $icon . $link['title'];
  }
  $output .= "</li>\n";

  return $output;
}

/**
 * Implements theme_status_messages().
 */
function freeee_status_messages($variables) {
  $display = $variables['display'];
  $output = '';
  $message_body = '<div class="modal-body">';
  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  $output .= '<div class="modal fade" id="messagesModal" tabindex="-1" role="dialog" aria-labelledby="StatusMessages" aria-hidden="true">'
      . '<div class="modal-dialog"><div class="modal-content"><div class="modal-header lead">' . t('Status messages')
      . '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
  foreach (drupal_get_messages($display) as $type => $messages) {
    switch ($type) :
      case 'status':
        $message_type = 'success';
        break;
      case 'error':
        $message_type = 'danger';
        break;
      case 'warning':
        $message_type = 'warning';
        break;
      default :
        $message_type = 'info';
        break;
    endswitch;
    $message_body .= "<div class=\"alert alert-$message_type\">\n";

    if (!empty($status_heading[$type])) {
      $message_body .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $message_body .= " <ul>\n";
      foreach ($messages as $message) {
        $message_body .= '  <li>' . $message . "</li>\n";
      }
      $message_body .= " </ul>\n";
    }
    else {
      $message_body .= $messages[0];
    }
    $message_body .= "</div>\n";
  }
  $output .= $message_body . "</div></div></div></div>\n";
  return $output;
}

function freeee_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // current is the page we are currently paged to
  $pager_current = $pager_page_array[$element] + 1;
  // first is the first page listed by this pager piece (re quantity)
  $pager_first = $pager_current - $pager_middle + 1;
  // last is the last page listed by this pager piece (re quantity)
  $pager_last = $pager_current + $quantity - $pager_middle;
  // max is the maximum page number
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array('text' => (isset($tags[0]) ? $tags[0] : t('« first')), 'element' => $element, 'parameters' => $parameters));
  $li_previous = theme('pager_previous', array('text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_next = theme('pager_next', array('text' => (isset($tags[3]) ? $tags[3] : t('next ›')), 'element' => $element, 'interval' => 1, 'parameters' => $parameters));
  $li_last = theme('pager_last', array('text' => (isset($tags[4]) ? $tags[4] : t('last »')), 'element' => $element, 'parameters' => $parameters));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array('text' => $i, 'element' => $element, 'interval' => ($pager_current - $i), 'parameters' => $parameters)),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => '<span>' . $i . '</span>',
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array('text' => $i, 'element' => $element, 'interval' => ($i - $pager_current), 'parameters' => $parameters)),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }
    return '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
      'items' => $items,
      'attributes' => array('class' => array('pagination')),
    ));
  }
}