<?php
// No direct access
defined( '_JEXEC' ) or die;


/**
 * Controller
 * @author Воропаев Валентин
 */


class ShoppingoverviewControllerSitemap extends JControllerLegacy
{

    function display( $cachable = false, $urlparams = array() )
    {

        $model = $this->getModel('sitemap');
        $baseUrl = JUri::base();


        header('Content-Type: application/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        // Категории
        $getCategories = $model->getCategories();
        foreach($getCategories as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'en/'.$item->alias.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->alias.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getCategories as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'ru/'.$item->alias.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->alias.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getCategories as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'he/'.$item->alias.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->alias.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->alias.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        // Обзоры
        $getItems = $model->getItems();
        foreach($getItems as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'en/'.$item->cat_alias.'/'.$item->alias_en.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->cat_alias.'/'.$item->alias_en.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->cat_alias.'/'.$item->alias_ru.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->cat_alias.'/'.$item->alias_he.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getItems as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'ru/'.$item->cat_alias.'/'.$item->alias_ru.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->cat_alias.'/'.$item->alias_en.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->cat_alias.'/'.$item->alias_ru.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->cat_alias.'/'.$item->alias_he.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getItems as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'he/'.$item->cat_alias.'/'.$item->alias_he.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/'.$item->cat_alias.'/'.$item->alias_en.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/'.$item->cat_alias.'/'.$item->alias_ru.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/'.$item->cat_alias.'/'.$item->alias_he.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        // Теги
        $getTags = $model->getTags();
        foreach($getTags as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'en/tags/tag/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/tags/tag/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getTags as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'ru/tags/tag/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/tags/tag/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getTags as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'he/tags/tag/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/tags/tag/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/tags/tag/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        // Авторы
        $getAuthors = $model->getAuthors();
        foreach($getAuthors as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'en/users/profile/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/users/profile/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getAuthors as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'ru/users/profile/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/users/profile/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        foreach($getAuthors as $item):
            echo '<url>'."\n";
            echo '<loc>'.$baseUrl.'he/users/profile/'.$item->id.'</loc>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="en" href="'.$baseUrl.'en/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="ru" href="'.$baseUrl.'ru/users/profile/'.$item->id.'"/>'."\n";
            echo '<xhtml:link rel="alternate" hreflang="he" href="'.$baseUrl.'he/users/profile/'.$item->id.'"/>'."\n";
            echo '</url>'."\n";
        endforeach;

        echo '</urlset>'."\n";
        exit();
    }

}