<?php
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\search\Search;

?>
  
<div id="header" class="container">
        <div class="logowrap">
                <div class="logo"><a href="/site/index"><img src="<?=Yii::$app->view->theme->baseUrl?>/images/common/enagape.org_logo_bluecolor.png" /></a></div>
                <?php echo Search::widget(); ?>
        </div>

        <div id="primary-navwrap" class="pr-navwrap">
        <?php
        $items = [
                'activateParents' => true,
                'encodeLabels' => false,
                'options' => ['id'=>'primary-nav', 'class' => 'pr-nav'],
                 'items' => [
                ]
        ];
        $menuModel = new app\models\Menu();
        $menus = $menuModel->getMenuItems();
        $i = 0;
        $qtid = isset($_GET['tt_id']) ? $_GET['tt_id'] : '';
        foreach ( $menus as $menu ) {
                $params = explode(':', $menu['menu_params']);
                if ( is_array($params) && $params[0] !== '' ) {
                        $url = [$menu['menu_link'], $params[0]=>$params[1]];
                        if ( $qtid == $params[1] ) {
                                $isActive = true;
                        }
                        else {
                                $isActive = false;                                
                        }
                }
                else {
                        $url = [$menu['menu_link']];
                        $isActive = true;
                }
                $url = (is_array($params) && $params[0] !== '') ? [$menu['menu_link'], $params[0]=>$params[1]] : [$menu['menu_link']];
                $items['items'][$i] = [
                        'label' => Yii::t('app', $menu['menu_label']),
                        'url' => $url,
                        'active'=>( in_array($this->context->route, unserialize($menu['menu_active'])) && $isActive ) ? true : false
                ];
               
                $children = $menuModel->getMenuItems('main', $menu['menu_id']);
                $j = 0;
                if (is_array($children)) {
                        $activeCount = 0;
                        foreach ($children as $child) {
                                $params2 = explode(':', $child['menu_params']);
                                if ( is_array($params2) && $params2[0] !== '' ) {
                                        $url = [$child['menu_link'], $params2[0]=>$params2[1]];
                                        if ( $qtid == $params2[1] ) {
                                                $isActive = true;
                                                $activeCount++;
                                        }
                                        else {
                                                $isActive = false;                                
                                        }
                                }
                                else {
                                        $url = [$child['menu_link']];
                                        $isActive = true;
                                }
                                $items['items'][$i]['items'][] = [
                                        'label' => Yii::t('app', $child['menu_label']),
                                        'url' => $url,
                                        'active'=>( in_array($this->context->route, unserialize($child['menu_active'])) && $isActive ) ? true : false
                                ];
                                
                                $activeCount2 = 0;
                                $grandchildren = $menuModel->getMenuItems('main', $child['menu_id']);
                                if (is_array($grandchildren)) {
                                        foreach ($grandchildren as $grandchild) {
                                                $params3 = explode(':', $grandchild['menu_params']);
                                                if ( is_array($params3) && $params3[0] !== '' ) {
                                                        $url = [$grandchild['menu_link'], $params3[0]=>$params3[1]];
                                                        if ( $qtid == $params3[1] ) {
                                                                $isActive = true;
                                                                $activeCount2++;
                                                        }
                                                        else {
                                                                $isActive = false;                                
                                                        }
                                                }
                                                else {
                                                        $url = [$grandchild['menu_link']];
                                                        $isActive = true;
                                                }
                                                $items['items'][$i]['items'][$j]['items'][] = [
                                                        'label' => Yii::t('app', $grandchild['menu_label']),
                                                        'url' => $url,
                                                        'active'=>( in_array($this->context->route, unserialize($child['menu_active'])) && $isActive ) ? true : false
                                                ];
                                        }
                                }
                                if ( $activeCount2 > 0 ) {
                                        $items['items'][$i]['items'][$j]['active'] = true;
                                        $activeCount++;
                                }
                                $j++;
                        }
                }
                if ( $activeCount > 0 ) {
                        $items['items'][$i]['active'] = true;
                }
                $i++;
        }
        if (Yii::$app->user->isGuest) {
                array_push($items['items'], ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']]);
                array_push($items['items'], ['label' => Yii::t('app', 'Sign up'), 'url' => ['/site/signup']]);
        }
        echo Menu::widget($items);
        ?>    
        </div>
</div><!--/#header-->


