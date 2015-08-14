<?php
/**
 * @file
 * dlrequest.tpl.php
 */

/**
 * Available variables:
 * $name - Name as entered
 * $last_name - Last name as entered
 * $email - E-mail adress as entered
 * $files - Rendered field with file attachments
 * $node - Full node of the webform node
 */
?>
<h2>Tak for din registrering!</h2>

<p>Dine registrerede informationer:</p>
<?php if (count($fields) > 0): ?>
<p><ul class="webform-fields">
<?php foreach ($fields as $field): ?>
<li><?php echo $field['label']?>: <?php echo $field['value']?></li>
<?php endforeach; ?>
</ul></p>
<?php endif; ?>

<?php if (!empty($files)) : ?>

<p>De ønskede filer kan downloades her:</p>
<?php echo drupal_render($files) ?>

<?php endif; ?>
