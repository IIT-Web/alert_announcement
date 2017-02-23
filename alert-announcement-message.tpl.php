<?php

/**
 * @file alert-announcement-message.tpl.php
 * Default template implementation to render the markup for the alert
 * announcement message.
 *
 * Available variables:
 * - $headline: String containing the text of the message headline field.
 * - $body: String containing the markup for the message body field.
 * - $variables: Array of variables passed to the template
 *   - id: Number representing the index of this field starting at 1
 *   - element: An associative array containing the properties of the element
 *   - field: An associative array containing the properties of the field
 *   - max_rss_results: A number of maximum results to show in the RSS feed.
 *     If no max is set this value will be empty.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - field: The current template type, i.e., "theming hook".
 *   - field-name-[field_name]: The current field name. For example, if the
 *     field name is "field_description" it would result in
 *     "field-name-field-description".
 *   - field-type-[field_type]: The current field type. For example, if the
 *     field type is "text" it would result in "field-type-text".
 *   - field-label-[label_display]: The current label position. For example, if
 *     the label position is "above" it would result in "field-label-above".
 *
 * Other variables:
 * - $element['url']: The entity to which the field is attached.
 * - $element['title']: View mode, e.g. 'full', 'teaser'...
 * - $element['attributes']: The field name.
 * - $element['attributes']['target']: The field type.
 * - $element['html']: The field language.
 * - $element['display_url']: Whether the field is translatable or not.
 *
 * @see template_preprocess_field()
 * @see theme_field()
 *
 * @ingroup themeable
 */
?>

<div id="alert-announcement-wrapper">
  <div><?php echo $headline; ?></div>
  <div><?php echo $body; ?></div>
</div>
