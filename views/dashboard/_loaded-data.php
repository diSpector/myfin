<?php

use app\widgets\DashboardForPeriodWidget\DashboardForPeriodWidget;

?>

<?php if (count($allGrouped) !== 0) : ?>

    <h2 class='text-center'><?= $title ?></h1>

        <?php foreach ($allGrouped as $date => $operations) : ?>
            <?= DashboardForPeriodWidget::widget(['title' => $date, 'model' => $operations]) ?>
        <? endforeach; ?>

    <?php else : ?>
        <h4 class="text-center">Операций нет</h4>
<?php endif; ?>