<?php

namespace hiqdev\yii2\mfa\widgets;


use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class BackTOTPLinkWidget
 * @package hiqdev\yii2\mfa\widgets
 */
class BackTOTPLinkWidget extends Widget
{
    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->registerJs();

        $backLink = HTML::a(Yii::t('mfa', 'Back'), '#', ['id' => 'back-link']);

        return "<div>$backLink</div>";
    }

    private function registerJs()
    {
        $referrer = Yii::$app->request->referrer;

        $this->view->registerJs(/** @lang JavaScript */"
            $('#back-link').on('click', () => {
                const phpReferrer = '{$referrer}';
                
                (phpReferrer === '') ? window.history.go(-1) : window.location.href = phpReferrer;
            });
        ");
    }
}
