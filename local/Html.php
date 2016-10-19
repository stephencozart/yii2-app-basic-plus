<?php namespace app\local;


class Html extends \yii\helpers\Html {

    /**
     * Show the flash messages
     */
    public static function showFlashMessages()
    {
        static::showFlashMessage("info");
        static::showFlashMessage("error");
        static::showFlashMessage("success");
    }

    /**
     * @param $key
     */
    public static function showFlashMessage($key)
    {
        if (\Yii::$app->session->hasFlash($key)) {
            $html = "<div class='alert alert-" . $key . "'>";
            $flashes = \Yii::$app->session->getFlash($key);
            if (is_array($flashes)) {
                if (count($flashes) > 1) {
                    $html .= "<ul>";
                    foreach ($flashes as $flash) {
                        $html .= "<li>" . $flash . "</li>";
                    }
                } else {
                    $html .= $flashes[0];
                }
            } else {
                $html .= $flashes;
            }
            $html .= "</div>";
            echo $html;
        }
    }
}