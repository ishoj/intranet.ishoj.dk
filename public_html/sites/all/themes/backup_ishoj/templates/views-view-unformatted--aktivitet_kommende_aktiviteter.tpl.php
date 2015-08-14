<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <div class="swiper-slide fix-width">
    <div class="date"><?php print $title; ?></div>
    <div class="circle"><div></div></div>
    <div class="description">
      <ul>
<?php endif; ?>

<?php foreach ($rows as $id => $row): ?>
  <?php print $row; ?>
<?php endforeach; ?>

<?php if (!empty($title)): ?>
      </ul>
    </div>
  </div>
<?php endif; ?>
