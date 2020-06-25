<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerSearch extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'getTags':
                $needcheck = 1;
                break;
        }

        if($needcheck == 1 && $user->get('guest') == 1){
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE'), 'warning');
            $app->Redirect('/');
        }

        parent::__construct( $config );
    }

    function display( $cachable = false, $urlparams = array() ){

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $search = $app->input->get('search', "", 'string');
        $type = $app->input->get('type', "titles", 'string');

        $model = $this->getModel('search');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        switch ($type) {
            case 'tags':
                $rows = $model->getListTagsDop($search,$lang,0);
                $count = $model->getListTags($search,$lang,0,true);
                break;
            case 'users':
                $rows = $model->getListUsersDop($search,0);
                $count = $model->getListUsers($search,$lang,0,true);
                break;
            default:
                $rows = $model->getListTitlesDop($search,$lang,0);
                $count = $model->getListTitles($search,$lang,0,true);
                break;
        }

        $rows = $model->getItemsIds($rows);

        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_SEARCH') );

        $view = $this->getView('search','html');
        $view->setLayout('default');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('type',$type);
        $view->assignRef('search',$search);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->assignRef('count',$count);
        $view->display();

    }

    function search( $cachable = false, $urlparams = array() ){

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $search = $app->input->get('search', "", 'string');
        $type = $app->input->get('type', "titles", 'string');

        $model = $this->getModel('search');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        switch ($type) {
            case 'tags':
                $rows = $model->getListTagsDop($search,$lang,0);
                $count = $model->getListTags($search,$lang,0,true);
                break;
            case 'users':
                $rows = $model->getListUsersDop($search,0);
                $count = $model->getListUsers($search,$lang,0,true);
                break;
            default:
                $rows = $model->getListTitlesDop($search,$lang,0);
                $count = $model->getListTitles($search,$lang,0,true);
                break;
        }

        $rows = $model->getItemsIds($rows);

        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_SEARCH') );

        $view = $this->getView('search','html');
        $view->setLayout('search');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('type',$type);
        $view->assignRef('search',$search);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->assignRef('count',$count);
        $view->display();

    }

    function ajaxSiteSearch( $cachable = false, $urlparams = array() ){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $search = $app->input->get('search', "", 'string');
        $type = $app->input->get('type', "titles", 'string');
        $count = $app->input->get('count', 0, 'int');

        $model = $this->getModel('search');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        switch ($type) {
            case 'tags':
                $rows = $model->getListTagsDop($search,$lang,$count);
                break;
            case 'users':
                $rows = $model->getListUsersDop($search,$count);
                break;
            default:
                $rows = $model->getListTitlesDop($search,$lang,$count);
                break;
        }

        $rows = $model->getItemsIds($rows);

        $result['count'] = $count + 10;

        ob_start();

        $i=1; foreach ( $rows as $item ):
            ?>
            <?=$modelAvertisings->advertisingsItem();?>
            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <?php require(JPATH_SITE.'/components/com_shoppingoverview/views/items/tmpl/item.php');?>
                </div>
            </div>

            <?php
            $i++;
        endforeach;

        $result['result'] = ob_get_contents();
        ob_end_clean();

        echo json_encode($result);
        exit();
    }

    function searchAjax(){
        header('Content-Type: application/json');
        $result = array('result' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $search = $app->input->get('search', "", 'string');
        $type = $app->input->get('type', "titles", 'string');

        $model = $this->getModel('search');

        switch ($type) {
            case 'tags':
                $rows = $model->getListTags($search,$lang,0);
                if(!empty($rows)) {
                    ob_start();
                    require_once(dirname(dirname(__FILE__)) . '/views/search/tmpl/autocomplete_tags.php');
                    $result['result'] = ob_get_contents();
                    ob_end_clean();
                }
                break;
            case 'users':
                $rows = $model->getListUsers($search,0);
                if(!empty($rows)) {
                    ob_start();
                    require_once(dirname(dirname(__FILE__)) . '/views/search/tmpl/autocomplete_users.php');
                    $result['result'] = ob_get_contents();
                    ob_end_clean();
                }
                break;
            default:
                $rows = $model->getListTitles($search,$lang,0);
                if(!empty($rows)) {
                    ob_start();
                    require_once(dirname(dirname(__FILE__)) . '/views/search/tmpl/autocomplete_titles.php');
                    $result['result'] = ob_get_contents();
                    ob_end_clean();
                }
                break;
        }

        echo json_encode($result);
        exit();
    }

}