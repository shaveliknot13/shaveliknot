<?php
// No direct access
defined( '_JEXEC' ) or die;

/**
 * Controller
 * @author Воропаев Валентин
 */


class ShoppingoverviewControllerItems extends JControllerLegacy
{

    function __construct( $config = array() )
    {
        $app = JFactory::getApplication();
        $task = $app->input->get('task','display');
        $user = JFactory::getUser();
        $needcheck = 0;

        switch ($task) {
            case 'useritems':
                $needcheck = 1;
                break;
            case 'edit':
                $needcheck = 1;
                break;
            case 'delete':
                $needcheck = 1;
                break;
            case 'save':
                $needcheck = 1;
                break;
            case 'saveTags':
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

    function categories( $cachable = false, $urlparams = array() )
    {

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $session = JFactory::getSession();

        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
        $cat_alias = $app->input->getString('cat_alias', null);
        $cat_alias = str_replace(':','-',$cat_alias);

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelCat = $this->getModel('categories');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $nameCat = $modelCat->getCategorie($cat_alias);

        $massArrFilter = $session->get('globalfilter', false);
        if($massArrFilter == false){
            $massArrFilter = (object) array(
                "filterSoCat"       => 0,
                "filterSoDay"       => 7,
                "filterSoPrice"     => 0,
                "filterSoDelivery"  => 0,
                "filterSoVideo"     => 0,
                "filterSoOrdering"  => 'latest'
            );
            $session->set('globalfilter', $massArrFilter);
        }

        $rows = $model->getListItems($cat_alias,$lang,$massArrFilter);

        shoppingoverviewSiteHelper::setDocument( $nameCat->{'title_'.$lang} );

        if( !empty($nameCat) ){
            $view = $this->getView('categories','html');
            $view->setLayout('default');
            $view->assignRef('rows',$rows);
            $view->assignRef('modelImages',$modelImages);
            $view->assignRef('nameCat',$nameCat);
            $view->assignRef('lang',$lang);
            $view->assignRef('modelTags',$modelTags);
            $view->assignRef('modelFavorites',$modelFavorites);
            $view->assignRef('massArrFilter',$massArrFilter);
            $view->assignRef('modelAvertisings',$modelAvertisings);
            $view->display();
        }else{
            return JError::raiseError(404, JText::_('COM_SHOPPINGOVERVIEW_CATEGORY_NOT_FOUND'));
        }

    }

    function edit( $cachable = false, $urlparams = array() )
    {
        $doc = &JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());
        shoppingoverviewSiteHelper::setDocument( 'add' );
        $id = $app->input->getInt('id', null);
        $user   = JFactory::getUser();

        $data = $app->getUserState('com_shoppingoverview.edit.data');

        $model = $this->getModel('items');
        $modelImages = $this->getModel('images');
        $modelTags = $this->getModel('tags');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');
        $form = $model->getForm();

        if(!empty($data)){
            $row = $data;
            $app->setUserState('com_shoppingoverview.edit.data', null);
        }else{
            $row = $model->getItemId($id,$user->id);
        }

        $view = $this->getView('items','html');
        $view->setLayout('edit');
        $view->assignRef('modelImages',$modelImages);
        $view->assignRef('modelTags',$modelTags);
        $view->assignRef('modelFavorites',$modelFavorites);
        $view->assignRef('row',$row);
        $view->assignRef('form',$form);
        $view->assignRef('lang',$lang);
        $view->assignRef('modelAvertisings',$modelAvertisings);
        $view->display();
    }

    function save( $cachable = false, $urlparams = array() )
    {

        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $data = $app->input->get('jform', array(), 'array');
        $model = $this->getModel('items');
        $modelImages = $this->getModel('images');
        $modelTags = $this->getModel('tags');
        $modelPrivilege = $this->getModel('privilege');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');
        $form = $model->getForm();
        $user   = JFactory::getUser();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $data['myFieldset']['user_id'] = $user->id;
        $data['myFieldset']['modified_user_id'] = $user->id;
        $data = DopFunction::arrayToObjects($data['myFieldset']);

        // картинки и текст формируються и проверяються на количество
        if(
            count($data->text_ru) == 10 && count($data->text_en) == 10 && count($data->text_he) == 10 &&
            count($data->images_ru) == 10 && count($data->images_en) == 10 && count($data->images_he) == 10
        )
        {

            $formating = $model->formating($data,$modelImages);

            // Обрезка названия
            $data->product = preg_replace('/[^a-zA-Z0-9\s!@#\$%\^&\*\(\)=_\-\+\?א-ת]/u', '', mb_substr( strip_tags($data->product), 0, 50, 'UTF-8'));

            $data->title_ru = mb_substr( strip_tags($data->title_ru), 0, 70, 'UTF-8');
            $data->title_en = mb_substr( strip_tags($data->title_en), 0, 70, 'UTF-8');
            $data->title_he = mb_substr( strip_tags($data->title_he), 0, 70, 'UTF-8');

            // Обрезка краткого описания
            $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
            $data->mini_text_ru = preg_replace($regex, '', mb_substr( strip_tags($data->mini_text_ru), 0, 10000, 'UTF-8'));
            $data->mini_text_en = preg_replace($regex, '', mb_substr( strip_tags($data->mini_text_en), 0, 10000, 'UTF-8'));
            $data->mini_text_he = preg_replace($regex, '', mb_substr( strip_tags($data->mini_text_he), 0, 10000, 'UTF-8'));

            // Обрезка
            $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
            $data->hwp_text_ru = preg_replace($regex, '', mb_substr( strip_tags($data->hwp_text_ru), 0, 10000, 'UTF-8'));
            $data->hwp_text_en = preg_replace($regex, '', mb_substr( strip_tags($data->hwp_text_en), 0, 10000, 'UTF-8'));
            $data->hwp_text_he = preg_replace($regex, '', mb_substr( strip_tags($data->hwp_text_he), 0, 10000, 'UTF-8'));

            $data->text_ru = $formating['content_ru'];
            $data->text_en = $formating['content_en'];
            $data->text_he = $formating['content_he'];

        }else{

            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_DATA_TRANSMITTED_INCORRECTLY'), 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');

        }

        // групируем кардинаты обрезки с id изоображений и уникализируем массив
        $imgCoordinates = $modelImages->formating($data);
        // проверяем принадлежат ли все картинки владельцу
        if( !$modelImages->validate($imgCoordinates) ){
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_DATA_TRANSMITTED_INCORRECTLY'), 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items');
        }

        // обрезаем картинку по кардинатам и создаем миниатюру
        $modelImages->crops($imgCoordinates);

        // валидация общих данных
        $validate = $model->validate($data);

        if(!$validate['status']){

            shoppingoverviewSiteHelper::setDocument( 'add' );

            $app->enqueueMessage($validate['text'], 'warning');
            $app->setUserState('com_shoppingoverview.edit.data', $data);
            $app->Redirect('index.php?option=com_shoppingoverview&task=edit');

        }else{

            $idItem = $model->save($data,$modelPrivilege->getPrivilege($user->id));

            if($idItem){

                $this->saveTags($data,$idItem,$lang);

                $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_SAVED'));
                $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=useritems');

            }else{

                $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_NOT_SAVED'), 'warning');
                $app->Redirect('index.php?option=com_shoppingoverview&controller=users&task=useritems');

            }

        }

    }

    function saveTags($data,$id,$lang){

        header('Content-Type: text/html; charset=UTF-8');

        $modelCat = $this->getModel('categories');
        $modelTags = $this->getModel('tags');
        $modelDeliverys = $this->getModel('deliverys');

        $argv = array();

        if(!empty($data->tags)) {
            foreach ($data->tags as $item) {
                $item = preg_replace('/[^а-яА-Яa-zA-Z0-9\s!@#\$%\^&\*\(\)=_\-\+\?א-ת]/u', '', $item);
                $argv[] = mb_substr(trim($item), 0, 35);
            }
        }

        // обязательные тэги
        $dataV1 = preg_replace('/[^а-яА-Яa-zA-Z0-9\s!@\$%\^&\*\(\)=_\-\+\?א-ת]/u', '', $data->product);
        $argv[] = mb_substr(trim($dataV1), 0, 35);

        $dataV2 = preg_replace('/[^а-яА-Яa-zA-Z0-9\s!@\$%\^&\*\(\)=_\-\+\?א-ת]/u', '', $modelCat->getItem($data->cat_id)->{'title_'.$lang});
        $argv[] = mb_substr(trim($dataV2), 0, 35);

        $dataV3 = preg_replace('/[^а-яА-Яa-zA-Z0-9\s!@\$%\^&\*\(\)=_\-\+\?א-ת]/u', '', $modelDeliverys->getItem($data->delivery_id)->{'title_'.$lang});
        $argv[] = mb_substr(trim($dataV3), 0, 35);

        $argv = array_unique($argv);
        $argv = array_diff($argv, array('', null, false));

        $modelTags->saveList($id,$argv,true);

    }

    function delete(){
        $app = JFactory::getApplication();
        $id = $app->input->getInt('id', null);
        $user   = JFactory::getUser();
        $model = $this->getModel('items');

        if( $model->getItemId($id, $user->id) ){

            $model->delete($id, $user->id);
            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_REMOVED'));
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items&task=useritems');

        }else{

            $app->enqueueMessage(JText::_('COM_SHOPPINGOVERVIEW_NOTHING_SELECTED'), 'warning');
            $app->Redirect('index.php?option=com_shoppingoverview&controller=items&task=useritems');

        }
    }

    function show( $cachable = false, $urlparams = array() )
    {

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $cat_alias = $app->input->getString('cat_alias', null);
        $cat_alias = str_replace(':','-',$cat_alias);
        $item_alias = $app->input->getString('item_alias', null);
        $item_alias = str_replace(':','-',$item_alias);

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelComments = $this->getModel('comments');
        $modelFavorites = $this->getModel('favorites');
        $modelUsersubscribes = $this->getModel('usersubscribes');
        $modelLikes = $this->getModel('likes');
        $modelYoutube = $this->getModel('youtube');
        $modelHits = $this->getModel('hits');
        $modelImages = $this->getModel('images');
        $modelAvertisings = $this->getModel('advertisings');

        $row = $model->getItem($cat_alias,$item_alias,$lang);

        // делаем обновление статистики раз в час
        $date = date("Y-m-d H:i:s");
        $beginDate = new DateTime( $row->up_date );
        $endDate   = new DateTime( $date );
        $intervalDate = $beginDate->diff($endDate);

        if($intervalDate->days != 0 || $intervalDate->h > 0){
            $infoFacebook = DopFunction::getInfoFacebook();
            $modelComments->countComments($row->id, $infoFacebook);
            $modelLikes->countLikes($row->id, $infoFacebook);
            $model->up_date($row->id);
        }

        // Теги для фейсбука
        $og = new stdClass();
        if($lang == 'ru'){ $og->locale = 'ru_RU';
        }elseif($lang == 'he'){ $og->locale = 'he_IL';
        }else{ $og->locale = 'en_GB';}
        $og->type = 'article';
        $og->title = $row->product.' '.$row->{'title_'.$lang};
        $og->site_name = JFactory::getConfig()->get('sitename');

        $og->description = $row->{'mini_text_'.$lang};
        if(empty($row->{'mini_text_'.$lang})){
            $og->description = $row->{'text_'.$lang};
        }

        $og->description = mb_strimwidth(strip_tags($og->description), 0, 220, "...");
        $og->description = str_replace(array("\n", "\r"), ' ', $og->description);
        $og->description = trim(preg_replace('/\s\s+/', ' ', $og->description));

        $og->app_id = '1658713200805550';
        // Когда появится сертификат нужно будет удалить эту строку и оставить вторую
        $og->url = 'http://shaveliknot.co.il/'.JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$row->cat_alias.'&item_alias='.$row->{'alias_'.$lang}.'&Itemid=101' );
        //$og->url = JRoute::_( 'index.php?option=com_shoppingoverview&cat_alias='.$row->cat_alias.'&item_alias='.$row->{'alias_'.$lang}.'&Itemid=101', true, 1 );

        // если есть картинка
        $img = DopFunction::explodeReg($row->{'text_'.$lang },$modelImages);
        if(!empty($img)){
            $img = str_replace(array('<img src="','"/>'),'',$img[1]->img);
            $og->image = JUri::base().ltrim($img, '/');
        }
        // Обычный тайтал
        shoppingoverviewSiteHelper::setDocument( $og->title, '','', $og);


        if($row){
            $modelHits->updateHits($row->id);
            $view = $this->getView('items', 'html');
            $view->setLayout('show');
            $view->assignRef('row', $row);
            $view->assignRef('lang',$lang);
            $view->assignRef('modelTags',$modelTags);
            $view->assignRef('modelComments',$modelComments);
            $view->assignRef('modelFavorites',$modelFavorites);
            $view->assignRef('modelUsersubscribes',$modelUsersubscribes);
            $view->assignRef('modelYoutube',$modelYoutube);
            $view->assignRef('modelImages',$modelImages);
            $view->assignRef('modelAvertisings',$modelAvertisings);
            $view->display();
        }else{
            return JError::raiseError(404, JText::_('COM_SHOPPINGOVERVIEW_REVIEW_NOT_FOUND'));
        }

    }

    function ajaxSiteCategories( $cachable = false, $urlparams = array() ){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $session = JFactory::getSession();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $cat_alias = $app->input->getString('cat_alias', null);
        $cat_alias = str_replace(':','-',$cat_alias);
        $count = $app->input->get('count', 10, 'int');

        $massArrFilter = $session->get('globalfilter', false);

        if($massArrFilter == false){
            $massArrFilter = (object) array(
                "filterSoCat"       => 0,
                "filterSoDay"       => 7,
                "filterSoPrice"     => 0,
                "filterSoDelivery"  => 0,
                "filterSoVideo"     => 0,
                "filterSoOrdering"  => 'latest'
            );
        }else{
            $massArrFilter = (object) array(
                "filterSoCat"       => $massArrFilter->filterSoCat,
                "filterSoDay"       => $massArrFilter->filterSoDay,
                "filterSoPrice"     => $massArrFilter->filterSoPrice,
                "filterSoDelivery"  => $massArrFilter->filterSoDelivery,
                "filterSoVideo"     => $massArrFilter->filterSoVideo,
                "filterSoOrdering"  => $massArrFilter->filterSoOrdering
            );
        }

        $session->set('globalfilter', $massArrFilter);

        if( empty($count) ){ $count = 10; }

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $rows = $model->getListItems($cat_alias,$lang,$massArrFilter,$count);

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

    function ajaxSiteCategories2( $cachable = false, $urlparams = array() ){
        header('Content-Type: application/json');
        $result = array('error' => 0, 'result' => '', 'count' => '');

        $doc = & JFactory::getDocument();
        $app = JFactory::getApplication();
        $session = JFactory::getSession();
        $lang =  shoppingoverviewSiteHelper::getPerfixLang($doc->getlanguage());

        $cat_alias = $app->input->getString('cat_alias', null);
        $cat_alias = str_replace(':','-',$cat_alias);
        $count = $app->input->get('count', 0, 'int');

        $filterSoPrice1 = $app->input->get('filterSoPrice1', 0, 'int');
        $filterSoPrice2 = $app->input->get('filterSoPrice2', 0, 'int');

        $filterSoDelivery = $app->input->get('filterSoDelivery', 0, 'int');
        $filterSoVideo = $app->input->get('filterSoVideo', 0, 'int');
        $filterSoOrdering = $app->input->getString('ordering', 'latest');

        $massArrFilter = $session->get('globalfilter', false);

        if($massArrFilter == false){
            $massArrFilter = (object) array(
                "filterSoCat"       => 0,
                "filterSoDay"       => 7,
                "filterSoPrice1"     => 0,
                "filterSoPrice2"     => 0,
                "filterSoDelivery"  => 0,
                "filterSoVideo"     => 0,
                "filterSoOrdering"  => 'latest'
            );
        }else{
            $massArrFilter = (object) array(
                "filterSoCat"       => $massArrFilter->filterSoCat,
                "filterSoDay"       => $massArrFilter->filterSoDay,
                "filterSoPrice1"     => $filterSoPrice1,
                "filterSoPrice2"     => $filterSoPrice2,
                "filterSoDelivery"  => $filterSoDelivery,
                "filterSoVideo"     => $filterSoVideo,
                "filterSoOrdering"  => $filterSoOrdering
            );
        }

        $session->set('globalfilter', $massArrFilter);

        if( empty($count) ){ $count = 0; }

        $model = $this->getModel('items');
        $modelTags = $this->getModel('tags');
        $modelImages = $this->getModel('images');
        $modelFavorites = $this->getModel('favorites');
        $modelAvertisings = $this->getModel('advertisings');

        $rows = $model->getListItems($cat_alias,$lang,$massArrFilter,$count);

        $result['count'] = 10;

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