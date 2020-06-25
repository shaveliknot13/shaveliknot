<?php

// No direct access
defined( '_JEXEC' ) or die;

/**
 * @author Воропаев Валентин
 */

jimport('joomla.application.component.modellist');

class ShoppingoverviewModelComments extends JModelList
{

    const TABLE = '#__shoppingoverview_comments';
    public $db;


    public function __construct($config = array())
    {

        parent::__construct($config);

        $params = &JComponentHelper::getParams('com_shoppingoverview');

        $option             = array();                      //Инициализация
        $option['driver']   = $params->get('bd_driver');    // Имя драйвера БД
        $option['host']     = $params->get('bd_host');      // Хост БД
        $option['user']     = $params->get('bd_user');      // Имя пользователя
        $option['password'] = $params->get('bd_password');  // Пароль
        $option['database'] = $params->get('bd_database');  // Имя БД
        $option['prefix']   = $params->get('bd_prefix');    // префикс (может быть пустым)

        $db = & JDatabase::getInstance( $option );
        parent::setDbo($db);
        $this->db = parent::getDbo();;
    }

    public function countComments($id=null,$resultArr)
    {

        if(isset($resultArr->error)){
            return 0;
        }else{

            $database = $this->db;
            $amx = 'SELECT id,count FROM '.self::TABLE.' WHERE post_id='.$database->quote($id);
            $database->setQuery($amx);
            $result = $database->loadObject();

            if($result != null){

                $amx = 'UPDATE '.self::TABLE.' SET count='.$database->quote($resultArr->engagement->comment_plugin_count).' WHERE id='.$database->quote($result->id);
                $database->setQuery($amx);
                $database->query();

            }else{

                $amx = 'INSERT INTO '.self::TABLE.'
                        (`post_id`,
                        `count`)
                        VALUES
                        ('.$database->quote($id).',
                        '.$database->quote($resultArr->engagement->comment_plugin_count).')';
                $database->setQuery($amx);
                $database->query();

            }

            return $resultArr->engagement->comment_plugin_count;
        }
    }


    public function commentsBlock(){

        $appID = '1658713200805550';
        $colorscheme = 'Light';
        $width = '100%';
        $widthFix = 0;
        $numposts = 10;
        $order_by = 'reverse_time';
        $fb_admins = 0;
        $admins = '';
        $output = '';

        // Check for reqired params
        if (!$appID) {
            return $output;
        }

        $doc = JFactory::getDocument();
        // ссылка
        $href = substr(JUri::root(), 0, -1).$_SERVER['REQUEST_URI'];
        $lang = JFactory::getLanguage();
        $langTag = str_replace('-', '_', $lang->getTag());

        // Admins
        if ($fb_admins == 1) {
            $doc->addCustomTag('<meta property="fb:app_id" content="' . $appID . '" />');
        } else {
            if ($admins) {
                foreach (explode('|', $admins) as $admin) {
                    $doc->addCustomTag('<meta property="fb:admins" content="' . $admin . '"/>');
                }
            }
        }

        // Fluid width fix
        if ($width == '100%' && $widthFix == 1) {
            $doc->addStyleDeclaration('.fb-comments, .fb-comments iframe[style], .fb-comments span {width: 100% !important;}');
        }

        // Generate output
        $output .= '<a name="itemCommentsAnchor" id="itemCommentsAnchor"></a>';
        $output .='
<div id="fb-root"></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/' . $langTag . '/sdk.js#xfbml=1&version=v2.3&appId=' . $appID . '";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));
</script>
<div class="fb-comments" data-order-by="' . $order_by . '" data-width="' . $width . '" data-href="' . $href . '" data-numposts="' . $numposts . '" data-colorscheme="' . $colorscheme . '"></div>
';

        return $output;
    }

}