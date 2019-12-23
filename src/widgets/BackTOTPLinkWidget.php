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
    private $options = [
        'id'    => 'back-link',
        'class' => 'text-secondary',
    ];

    /**
     * @inheritDoc
     */
    public function run()
    {
        $this->registerJs();

        $backLink = HTML::a(Yii::t('mfa', 'Back'), '#', $this->options);

        return "<div style='margin-top: 15px;'>$backLink</div>";
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
