<?php
use yii\helpers\Html;
\app\modules\admin\AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script>
        document.vuePlugins = [
            {
                namespace: 'dashboard',
                region: 'main',
                name: 'greeting',
                component() {
                    return {
                        name: 'greeting',
                        template: '<div class="greeting">Hey {{ firstName }},  how is it going today?</div>',
                        data() {
                            return {

                            }
                        },
                        computed: {
                            user() {
                                return this.$store.state.user;
                            },
                            firstName() {
                                return this.user.first_name.charAt(0).toUpperCase() + this.user.first_name.slice(1)
                            }
                        }
                    }
                }
            }
        ];

    </script>
</head>
<body>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>