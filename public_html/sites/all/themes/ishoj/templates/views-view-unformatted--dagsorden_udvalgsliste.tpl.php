<?php
/**
 * @file views-view-unformatted.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
<div class="microArticle">
  <h3 class="mArticle" id="mArticle0"><span class="sprites-sprite sprite-plus mikroartikel"></span><?php print $title; ?></h3> 
    <div class="mArticle0 mArticle">
      <h3>Møder i <?php print $title; ?>:</h3>
      <ul>
<?php endif; ?>

<?php foreach ($rows as $id => $row): ?>
    <?php print strtolower($row); ?>
<?php endforeach; ?>
    </ul>
  </div>
</div>