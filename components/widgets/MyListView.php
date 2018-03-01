<?php

/*
 * MyListView.php
 */

namespace app\components\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Description of MyListView
 *
 * @author Suhk, Sangbom
 */
class MyListView extends \yii\widgets\ListView
{
    public $params = null;
    public $listBeginTag = null;
    public $listEndTag = null;
    /**
     * @var string the layout that determines how different sections of the list view should be organized.
     * The following tokens will be replaced with the corresponding section contents:
     *
     * - `{summary}`: the summary section. See [[renderSummary()]].
     * - `{header}`: the summary section. See [[renderSummary()]].
     * - `{items}`: the list items. See [[renderItems()]].
     * - `{sorter}`: the sorter. See [[renderSorter()]].
     * - `{pager}`: the pager. See [[renderPager()]].
     */
    public $layout = null;
    public $listHeaderColor;
    public $listHeaderLineColor;
    public $listHeaderFontColor;
    

    /**
     * Renders a section of the specified name.
     * If the named section is not supported, false will be returned.
     * @param string $name the section name, e.g., `{summary}`, `{items}`.
     * @return string|boolean the rendering result of the section, or false if the named section is not supported.
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{summary}':
                return $this->renderSummary();
            case '{listBeginTag}':
                return $this->renderListBeginTag();
            case '{header}':
                return $this->renderHeader();
            case '{items}':
                return $this->renderItems();
            case '{listEndTag}':
                return $this->renderListEndTag();
            case '{pager}':
                return $this->renderPager();
            case '{sorter}':
                return $this->renderSorter();
            default:
                return false;
        }
    }
    
    /**
     * Render post list table head.
     * @params array
     */
    public function renderHeader()
    {
        $header = '<tr class="list-row" style="background-color:#' . $this->listHeaderColor . ';border-top:2px solid #' 
                . $this->listHeaderLineColor . ';color:#' . $this->listHeaderFontColor . '">';
        foreach ($this->params as $key => $value) {
            $header .= '<th class="th-' . $key . '">' . $value . '</th>';
        }
        $header .= '</tr>';
        
        return $header;
    }

    /**
     * @Override
     * Renders the HTML content indicating that the list view has no data.
     * @return string the rendering result
     * @see emptyText
     */
    public function renderEmpty()
    {
        $options = $this->emptyTextOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'td');        
        return $this->renderListBeginTag() . $this->renderHeader() . sprintf( '<tr class="list-row">%s</tr>', Html::tag($tag, $this->emptyText, $options)) . $this->renderListEndTag();
    }

    /**
     * @Override ListView rederItems method.
     * @return string the rendering result
     */
    public function renderItems()
    {
        $models = $this->dataProvider->getModels();
        $keys = $this->dataProvider->getKeys();
        $rows = [];
        foreach (array_values($models) as $index => $model) {
            $rows[] = $this->renderItem($model, $keys[$index], $index);
        }

        return implode($this->separator, $rows);
    }
    
    /**
     * Begin Table.
     * @return string
     */
    public function renderListBeginTag()
    {        
        return ($this->listBeginTag) ? $this->listBeginTag : '<table class="list-table">';
    }
    
    /**
     * Close Table.
     */
    public function renderListEndTag()
    {
        return  ($this->listBeginTag) ? $this->listEndTag : '</table>';
    }

    /**
     * @Override.
     * @param mixed $model the data model to be rendered
     * @param mixed $key the key value associated with the data model
     * @param integer $index the zero-based index of the data model in the model array returned by [[dataProvider]].
     * @return string the rendering result
     */
    public function renderItem($model, $key, $index)
    {
        if ($this->itemView === null) {
            $content = $key;
        } elseif (is_string($this->itemView)) {
            $content = $this->getView()->render($this->itemView, array_merge([
                'model' => $model,
                'key' => $key,
                'index' => $index,
                'widget' => $this,
            ], $this->viewParams));
        } else {
            $content = call_user_func($this->itemView, $model, $key, $index, $this);
        }
        $options = $this->itemOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');        
        if ($tag !== false) {
            $options['data-key'] = is_array($key) ? json_encode($key, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : (string) $key;

            return Html::tag($tag, $content, $options);
        } else {
            return $content;
        }
    }
}
