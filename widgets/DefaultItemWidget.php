<?php 

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class DefaultItemWidget extends Widget
{
    public $text;

    public function init()
    {
        parent::init();
        if ($this->text === null) {
            $this->text = 'Элемент списка';
        }
    }

    public function run()
    {
        return Html::a($this->text, '', ['class' => 'link-default-category']);
    }
}