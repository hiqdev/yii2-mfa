<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title><?= Yii::t('mfa', 'Redirecting...') ?></title>
    </head>
    <body onload="setTimeout(go, 1000);">
        <script language="javascript">
            function go() {
                window.location = "<?= htmlspecialchars($url) ?>";
            }
        </script>
        <div class="center" width="100%">
            <a href="<?= htmlspecialchars($url) ?>"><?= Yii::t('mfa', 'Redirecting...') ?></a>
        </div>
    </body>
</html>
