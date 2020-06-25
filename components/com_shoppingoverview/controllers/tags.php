<?php

// No direct access
defined( '_JEXEC' ) or die;

class ShoppingoverviewControllerTags extends JControllerLegacy
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
        $app = JFactory::getApplication();
        $app->Redirect('/');
    }

    function tag( $cachable = false, $urlparams = array() )
    {
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', 0);
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $tag = $modelTags->getItemId($id);

        if(!$tag->id){
            return JError::raiseError(404, JText::_('COM_SHOPPINGOVERVIEW_TAG_NOT_FOUND'));
        }

        $postsId = $modelTags->getItemsId($id);

        $resultPostsId = array();
        foreach($postsId as $item){
            $resultPostsId[] = $item->post_id;
        }
        $ids = implode(',', $resultPostsId);

        $rows = $modelTags->getItemsIds($ids);

        shoppingoverviewSiteHelper::setDocument( JText::sprintf( 'COM_SHOPPINGOVERVIEW_REVIEW_TAG', $tag->title ) );

        $view = $this->getView('tags','html');
        $view->setLayout('default');
        $view->assignRef('tag',$tag);
        $view->assignRef('rows',$rows);
        $view->assignRef('user',$user);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();

    }

    function getTags(){
        header('Content-Type: application/json');
        $result = array('result' => '');

        $doc    = JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
        $search = $app->input->get('search', "", 'string');
        $model = $this->getModel('tags');

        $rows = $model->getListItemsAjax($search,$lang);

        if(!empty($rows)){

            ob_start();
            require_once(dirname(dirname(__FILE__)) . '/views/tags/tmpl/autocomplete.php');
            $result['result'] = ob_get_contents();
            ob_end_clean();

        }

        echo json_encode($result);
        exit();
    }

    function ajaxSiteTags( $cachable = false, $urlparams = array() ){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $app = JFactory::getApplication();
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $id = $app->input->getInt('id', 0);
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $tag = $modelTags->getItemId($id);

        if(!$tag->id){
            die();
        }

        $postsId = $modelTags->getItemsId($id,$count);

        $resultPostsId = array();
        foreach($postsId as $item){
            $resultPostsId[] = $item->post_id;
        }
        $ids = implode(',', $resultPostsId);

        $rows = $modelTags->getItemsIds($ids);

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

}