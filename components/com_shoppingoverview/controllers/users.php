<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * Controller
 * @author Воропаев Валентин
 */
class ShoppingoverviewControllerUsers extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'userItems':
                $needcheck = 1;
                break;
            case 'userFavorites':
                $needcheck = 1;
                break;
            case 'deleteFavorite':
                $needcheck = 1;
                break;
            case 'userHits':
                $needcheck = 1;
                break;
        }

        if($needcheck == 1 && $user->get('guest') == 1){
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_LOG_IN_TO_THE_SITE'), 'warning');
            $app->Redirect('/');
        }

        parent::__construct( $config );
    }

    function display( $cachable = false, $urlparams = array() )
    {

        $view = $this->getView('items','html');
        $view->setLayout('default');
        $view->display();

    }

    function login( $cachable = false, $urlparams = array() )
    {

        $view = $this->getView('users','html');
        $view->setLayout('login');
        $view->display();

    }

    function userFavorites()
    {
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $app = JFactory::getApplication();
        $cat_id = $app->input->getInt('id', 0);

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $cat = $modelFavorites->itemFavoriteCat($user);

        $ids = $modelFavorites->getUserFavoritesDop($user,0,$cat_id);
        $rows = $modelFavorites->getUserFavorites($ids);

        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_MY_FAVORITES') );

        $view = $this->getView('users','html');
        $view->setLayout('userfavorites');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('cat',$cat);
        $view->assignRef('cat_id',$cat_id);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function userSubscribes()
    {
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $app = JFactory::getApplication();
        $cat_id = $app->input->getInt('id', 0);

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelUsersubscribes = $this->getModel('usersubscribes');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $cat = $modelUsersubscribes->itemSubscribseCat($user->id);

        $ids = $modelUsersubscribes->getUserSubscribesDop($user->id);
        $rows = $modelUsersubscribes->getUserSubscribse($ids, 0, $cat_id);


        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_MY_SUBSCRIPTIONS') );

        $view = $this->getView('users','html');
        $view->setLayout('usersubscribes');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('cat',$cat);
        $view->assignRef('cat_id',$cat_id);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function deleteSubscribe ( $cachable = false, $urlparams = array() )
    {
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);
        $user   = JFactory::getUser();
        $model = $this->getModel('usersubscribes');

        $result = $model->userSubscribe($id,$user->id);

        if( $result ){

            $model->userSubscribeUpdate($id,$user->id,0);
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_UNSUBSCRIBED'));
            $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes');

        }else{

            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_NOTHING_SELECTED'), 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=usersubscribes');

        }
    }

    function deleteFavorite ( $cachable = false, $urlparams = array() )
    {
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);
        $user   = JFactory::getUser();
        $model = $this->getModel('favorites');

        $result = $model->itemFavorite($id, $user);

        if( $result ){

            $model->itemFavoriteUpdate($result->id, 0);
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_REMOVED'));
            $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=userfavorites');

        }else{

            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_NOTHING_SELECTED'), 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=userfavorites');

        }
    }

    function userItems( $cachable = false, $urlparams = array() )
    {
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $app = JFactory::getApplication();
        $cat_id = $app->input->getInt('id', 0);

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $cat = $model->itemCat($user->id);

        $rows = $model->getUserItems($user->id, 0, $cat_id);

        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_MY_REVIEWS') );

        $view = $this->getView('users','html');
        $view->setLayout('useritems');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('cat',$cat);
        $view->assignRef('cat_id',$cat_id);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function userHits( $cachable = false, $urlparams = array() )
    {
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser();
        $app = JFactory::getApplication();
        $cat_id = $app->input->getInt('id', 0);

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $model = $this->getModel('items');
        $modelHits = $this->getModel('hits');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $cat = $modelHits->itemHitsCat($user->id);

        $ids = $modelHits->getUserHitsDop($user->id);
        $rows = $modelHits->getUserHits($ids, 0, $cat_id);

        shoppingoverviewSiteHelper::setDocument( JText::_('COM_SHOPPINGOVERVIEW_WATCH_HISTORY') );

        $view = $this->getView('users','html');
        $view->setLayout('userhits');
        $view->assignRef('rows',$rows);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('cat',$cat);
        $view->assignRef('cat_id',$cat_id);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function profile( $cachable = false, $urlparams = array() )
    {
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);
        $doc    = JFactory::getDocument();
        $user   = JFactory::getUser($id);

        if(!$user->id){
            return JError::raiseError(404, JText::_('COM_SHOPPINGOVERVIEW_USER_IS_NOT_FOUND'));
        }

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $rows = $model->getUserItems($user->id);

        shoppingoverviewSiteHelper::setDocument( JText::sprintf('COM_SHOPPINGOVERVIEW_REVIEW_PROFILE',$user->username) );


        $view = $this->getView('users','html');
        $view->setLayout('profile');
        $view->assignRef('rows',$rows);
        $view->assignRef('user',$user);
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function ajaxSiteProfile( $cachable = false, $urlparams = array() )
    {
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $user  = $app->input->get('id', null, 'int');
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $rows = $model->getUserItems($user,$count);

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

    function ajaxSiteUseritems( $cachable = false, $urlparams = array() )
    {
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $user  = JFactory::getUser();
        $cat_id = $app->input->getInt('id', 0);
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $rows = $model->getUserItems($user->id, $count, $cat_id);

        $result['count'] = $count + 10;

        ob_start();

        $i=1; foreach ( $rows as $item ):
            ?>
            <?=$modelAvertisings->advertisingsItem();?>
            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <div class="function-admin">
                        <a class="edit-amx" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&task=edit&Itemid=101&id='.$item->id ); ?>"> <i class="fal fa-edit"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_EDIT'); ?></a>
                        <a class="delete-amx" onclick="return confirm('<?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE_VOPROS'); ?>')" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&task=delete&Itemid=101&id='.$item->id ); ?>"> <i class="fal fa-trash-alt"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE'); ?></a>
                    </div>
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

    function ajaxSiteUserfavorites( $cachable = false, $urlparams = array() )
    {
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $user  = JFactory::getUser();
        $cat_id = $app->input->getInt('id', 0);
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $ids = $modelFavorites->getUserFavoritesDop($user, $count, $cat_id);
        $rows = $modelFavorites->getUserFavorites($ids);
        $result['count'] = $count + 10;

        ob_start();

        $i=1; foreach ( $rows as $item ):
            ?>
            <?=$modelAvertisings->advertisingsItem();?>
            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <div class="function-admin">
                        <a class="delete-amx" onclick="return confirm('<?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE_VOPROS'); ?>')" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=deletefavorite&Itemid=101&id='.$item->id ); ?>"> <i class="fal fa-trash-alt"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_DELETE'); ?></a>
                    </div>
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

    function ajaxSiteUsersubscribes( $cachable = false, $urlparams = array() )
    {
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $user  = JFactory::getUser();
        $cat_id = $app->input->getInt('id', 0);
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelUsersubscribes = $this->getModel('usersubscribes');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $ids = $modelUsersubscribes->getUserSubscribesDop($user->id);
        $rows = $modelUsersubscribes->getUserSubscribse($ids, $count, $cat_id);

        $result['count'] = $count + 10;

        ob_start();

        $i=1; foreach ( $rows as $item ):
            ?>
            <?=$modelAvertisings->advertisingsItem();?>
            <div class="shoppingoverview-page-item">
                <div class="shoppingoverview-page-item-original">
                    <div class="function-admin">
                        <a class="delete-amx" onclick="return confirm('<?php echo JText::_('COM_SHOPPINGOVERVIEW_UNSUBSCRIBE_VOPROS'); ?>')" href="<?php echo JRoute::_( 'index.php?option=com_shoppingoverview&controller=users&task=deletesubscribe&Itemid=101&id='.$item->user_id ); ?>"> <i class="far fa-minus-circle"></i> <?php echo JText::_('COM_SHOPPINGOVERVIEW_UNSUBSCRIBE'); ?></a>
                    </div>
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

    function ajaxSiteUserHits( $cachable = false, $urlparams = array() )
    {
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $user  = JFactory::getUser();
        $cat_id = $app->input->getInt('id', 0);
        $count = $app->input->get('count', 10, 'int');

        if( empty($count) ){ $count = 10; }

        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelUserhits = $this->getModel('hits');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $ids = $modelUserhits->getUserHitsDop($user->id);
        $rows = $modelUserhits->getUserHits($ids, $count);

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