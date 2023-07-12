<?php

/**
 * @file
 * Implements().
 */

use Drupal\Core\Form\FormStateInterface;

/**
 * @file
 * Dark_awesome theme file.
 */

/**
 * Dark awesome form alter.
 */
function dark_awesome_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {
  if ($form['#attributes']['class'][0] == 'system-theme-settings') {
    $form['#attached']['library'][] = 'dark_awesome/theme.setting';
    $options_theme = [
      'left' => 'Left Side',
      'right' => 'Right Side',
    ];

    // Slide show.
    $form['banner']['slideshow'] = [
      '#type' => 'details',
      '#title' => t('Slider'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['banner']['slideshow']['slideshow_display'] = [
      '#type' => 'checkbox',
      '#title' => t('Show slideshow'),
      '#default_value' => theme_get_setting('slideshow_display', 'dark_awesome'),
      '#description'   => t("Check this option to show Slideshow in front page. Uncheck to hide."),
    ];
    $form['banner']['slideshow']['slide'] = [
      '#markup' => t('You can change the description and URL of each slide in the following Slide Setting fieldsets.'),
    ];
    for ($i = 1; $i <= 3; $i++) {
      $form['banner']['slideshow']['slide' . $i] = [
        '#type' => 'fieldset',
        '#title' => ('Slide' . $i),
        '#attributes' => [
          'id' => 'slide' . $i,
          'class' => ['slide-show'],
        ],
      ];
      $form['banner']['slideshow']['slide' . $i]['slide' . $i . '_head'] = [
        '#type' => 'textfield',
        '#title' => t('Slide Headline'),
        '#default_value' => theme_get_setting('slide' . $i . '_head', 'dark_awesome'),
      ];
      $form['banner']['slideshow']['slide' . $i]['slide' . $i . '_desc'] = [
        '#type' => 'textarea',
        '#title' => t('Slide Description'),
        '#default_value' => theme_get_setting('slide' . $i . '_desc', 'dark_awesome'),
      ];
      $form['banner']['slideshow']['slide' . $i]['slide' . $i . '_url'] = [
        '#type' => 'textfield',
        '#title' => t('Slide URL'),
        '#default_value' => theme_get_setting('slide' . $i . '_url', 'dark_awesome'),
      ];
      $form['banner']['slideshow']['slide' . $i]['slide' . $i . '_link_text'] = [
        '#type' => 'textfield',
        '#title' => t('Link Text'),
        '#default_value' => theme_get_setting('slide' . $i . '_link_text', 'dark_awesome'),
      ];

    }

    // Header image.
    $form['show_header_image_details']['header_details'] = [
      '#type' => 'details',
      '#title' => t('Header image'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['show_header_image_details']['header_details']['show_header_image_details'] = [
      '#type' => 'checkbox',
      '#title' => t('Show header image'),
      '#default_value' => theme_get_setting('show_header_image_details'),
      '#description'   => t("Show/Hide header_image"),
    ];
    $form['show_header_image_details']['header_details']['header_image'] = [
      '#type' => 'managed_file',
      '#title' => t('Header image'),
      '#default_value' => theme_get_setting('header_image', 'dark_awesome'),
      '#upload_location' => 'public://',
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg svg'],
      ],
    ];

    // Footer first.
    $form['show_footer_first_details']['footer_details'] = [
      '#type' => 'details',
      '#title' => t('Footer first details'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['show_footer_first_details']['footer_details']['show_footer_first_details'] = [
      '#type' => 'checkbox',
      '#title' => t('Show footer details'),
      '#default_value' => theme_get_setting('show_footer_first_details'),
      '#description'   => t("Show/Hide footer details"),
    ];
    $form['show_footer_first_details']['footer_details']['footer_image'] = [
      '#type' => 'managed_file',
      '#title' => t('Footer image'),
      '#default_value' => theme_get_setting('footer_image', 'dark_awesome'),
      '#upload_location' => 'public://',
      '#upload_validators' => [
        'file_validate_extensions' => ['gif png jpg jpeg'],
      ],
    ];
    $form['show_footer_first_details']['footer_details']['footer_text'] = [
      '#type' => 'textarea',
      '#title' => t('Footer first text'),
      '#default_value' => theme_get_setting('footer_text'),
      '#description' => t("Text area for Footer first"),
    ];

    // Contact details.
    $form['show_contact_details']['contact_details'] = [
      '#type' => 'details',
      '#title' => t('Footer Contact details'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['show_contact_details']['contact_details']['show_contact_details'] = [
      '#type' => 'checkbox',
      '#title' => t('Show contact details'),
      '#default_value' => theme_get_setting('show_contact_details'),
      '#description'   => t("Show/Hide contact_details"),
    ];
    $form['show_contact_details']['contact_details']['footer_contact'] = [
      '#type' => 'textfield',
      '#title' => t('Contact'),
      '#default_value' => theme_get_setting('footer_contact'),
      '#description' => t("Text field for Contact Heading."),
    ];
    $form['show_contact_details']['contact_details']['location'] = [
      '#type' => 'textfield',
      '#title' => t('Location'),
      '#default_value' => theme_get_setting('location'),
      '#description' => t("Text field for location"),
    ];
    $form['show_contact_details']['contact_details']['phone'] = [
      '#type' => 'textfield',
      '#title' => ('Phone'),
      '#default_value' => theme_get_setting('phone'),
      '#maxlength' => 64,
      '#size' => 64,
    ];
    $form['show_contact_details']['contact_details']['emails'] = [
      '#type' => 'email',
      '#title' => ('Email'),
      '#default_value' => theme_get_setting('emails'),
      '#description' => t("Enter your email"),
    ];

    // Social media icons.
    $form['show_social_icon']['social_icon'] = [
      '#type' => 'details',
      '#title' => t('Social Media Link'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['show_social_icon']['social_icon']['show_social_icon'] = [
      '#type' => 'checkbox',
      '#title' => t('Show Social Icons'),
      '#default_value' => theme_get_setting('show_social_icon'),
      '#description'   => t("Show/Hide social media links"),
    ];
    $form['show_social_icon']['social_icon']['facebook_url'] = [
      '#type' => 'textfield',
      '#title' => t('Facebook Link'),
      '#default_value' => theme_get_setting('facebook_url'),
    ];
    $form['show_social_icon']['social_icon']['twitter_url'] = [
      '#type' => 'textfield',
      '#title' => t('Twitter Link'),
      '#default_value' => theme_get_setting('twitter_url'),
    ];
    $form['show_social_icon']['social_icon']['instagram_url'] = [
      '#type' => 'textfield',
      '#title' => t('Instagram Link'),
      '#default_value' => theme_get_setting('instagram_url'),
    ];
    $form['show_social_icon']['social_icon']['linkedin_url'] = [
      '#type' => 'textfield',
      '#title' => t('Linkedin Link'),
      '#default_value' => theme_get_setting('linkedin_url'),
    ];
    $form['show_social_icon']['social_icon']['youtube_url'] = [
      '#type' => 'textfield',
      '#title' => t('Youtube Link'),
      '#default_value' => theme_get_setting('youtube_url'),
    ];
    $form['show_social_icon']['social_icon']['vimeo_url'] = [
      '#type' => 'textfield',
      '#title' => t('Vimeo Link'),
      '#default_value' => theme_get_setting('vimeo_url'),
    ];
    $form['show_social_icon']['social_icon']['telegram_url'] = [
      '#type' => 'textfield',
      '#title' => t('Telegram Link'),
      '#default_value' => theme_get_setting('telegram_url'),
    ];
    $form['show_social_icon']['social_icon']['whatsapp_url'] = [
      '#type' => 'textfield',
      '#title' => t('Whatsapp Link'),
      '#default_value' => theme_get_setting('whatsapp_url'),
    ];
    $form['show_social_icon']['social_icon']['github_url'] = [
      '#type' => 'textfield',
      '#title' => t('Github Link'),
      '#default_value' => theme_get_setting('github_url'),
    ];

    // Footer copyright.
    $form['footer_details'] = [
      '#type' => 'details',
      '#title' => t('Copyright'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['footer_details']['footer_details'] = [
      '#type' => 'checkbox',
      '#title' => t('Show Copyright'),
      '#default_value' => theme_get_setting('footer_details'),
      '#description'   => t("Show/Hide Copyright"),
    ];
    $form['footer_details']['footer_copyright'] = [
      '#type' => 'textarea',
      '#title' => t('Footer Copyright:'),
      '#default_value' => theme_get_setting('footer_copyright'),
      '#description' => t("Text area for Footer Copyright."),
    ];

    // Scroller details.
    $form['body_details'] = [
      '#type' => 'details',
      '#title' => t('Scroller Arrow'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $form['body_details']['body_details'] = [
      '#type' => 'checkbox',
      '#title' => t('Show Scroller'),
      '#default_value' => theme_get_setting('body_details'),
      '#description'   => t("Show/Hide Scroller"),
    ];
    $form['body_details']['arrow_up'] = [
      '#type' => 'select',
      '#title' => t("Arrow up Left/Right:"),
      '#default_value' => theme_get_setting('arrow_up'),
      '#description' => t("Arrow up icon position"),
      '#options' => $options_theme,

    ];

    $form['#submit'][] = 'dark_awesome_settings_form_submit';
    $theme = \Drupal::theme()->getActiveTheme()->getName();
    $theme_file = \Drupal::service('extension.list.theme')->getPath($theme) . '/dark_awesome.theme';
    $build_info = $form_state->getBuildInfo();
    if (!in_array($theme_file, $build_info['files'])) {
      $build_info['files'][] = $theme_file;
    }
    $form_state->setBuildInfo($build_info);

  }
}
