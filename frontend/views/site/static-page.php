<?php
/**
 * @var yii\web\View $this
 */
$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="body-content">
    <?= $model->full_text; ?>
</div>

