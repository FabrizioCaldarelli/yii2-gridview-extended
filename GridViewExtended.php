<?php

namespace sfmobile\ext\gridViewExtended;

/**
 * GridViewExtended
 * @copyright Copyright &copy; Fabrizio Caldarelli, sfmobile.it, 2017
 * @package yii2-gridview-extended
 * @version 1.0.1
 */
 class GridViewExtended extends \yii\grid\GridView
 {
     /**
     * Enable go to view detail clicking on the row
     */
     public $enableRowClickToView = true;

     /**
     * Automatically add action column at the end of the row
     */
     public $addActionColumn = true;

     /**
     * If enableRowClickToView is true, when user will click on the row, this javascript code will be called
     */
     public $rowClickJavascriptCallback = null;

     /**
     * Css class for row with data (not empty row)
     */
     public $rowDataCssClass = 'row-data';

     /**
     * Enable default extended table css class
     * @since 1.0.1
     */
     public $enableDefaultExtendedTableCssClass = true;

     /**
     * We need to distinguish row data from empty row. Since tableRow data GridView implementation
     * does not add info class, we have to add a class token to distinguish row data.
     */
     protected function extendsRowOptions()
     {
         // --------------
         // RowOptions
         // --------------
         $userRowOptions = $this->rowOptions;
         $this->rowOptions = function ($model, $key, $index, $grid) use($userRowOptions) {

             $options = null;
             if($userRowOptions!=null)
             {
                 if ($userRowOptions instanceof \Closure) {
                     $options = call_user_func($userRowOptions, $model, $key, $index, $this);
                 } else {
                     $options = $userRowOptions;
                 }
             }
             //var_dump($options);exit;

             if(isset($options['class']) ==false)
             {
                 $options['class'] = $this->rowDataCssClass;
             }
             else
             {
                 $options['class'] .= ' '.$this->rowDataCssClass;
             }

             return $options;
         };
     }

     /**
     * When we enableRowClickToView, ActionColumn should show only delete function, because
     * the other functions can be used clicking on the row.
     */
     protected function checkIfNeedToAddActionColum()
     {
         if($this->addActionColumn)
         {
             $this->columns[] = [
                 'class' => 'yii\grid\ActionColumn',
                 'visibleButtons' =>
                 [
                     'view' => false,
                     'update' => false,
                     'delete' => true
                 ],
             ];
         }
     }

     /**
     * If enableRowClickToView is true, we have to have js and css code to handle click on row-data
     */
     protected function checkIfNeedToEnableRowClickToView()
     {
         if($this->enableRowClickToView)
         {
             $id = $this->options['id'];
             $viewUrl = \yii\helpers\Url::to(['view']);

             $this->getView()->registerCss("
                 #{$id} table tbody tr.{$this->rowDataCssClass}:hover {
                     cursor:pointer
                 }
             ");

             $javascriptCallback = $this->rowClickJavascriptCallback;
             if($javascriptCallback == null)
             {
                 $javascriptCallback = "location = '{$viewUrl}?id='+$(this).attr('data-key');";
             }

             $this->getView()->registerJs(sprintf("
                 $(document).on('click', '#{$id} table tbody tr.{$this->rowDataCssClass}', function(ev) {
                     %s
                 });
             ", $javascriptCallback));
         }
     }

     /**
     * If enableDefaultExtendedTableCssClass is true, add bootstrap css classes for table
     * @since 1.0.1
     */
     protected function checkIfNeedToEnableDefaultExtendedTableCssClass()
     {
         if($this->enableDefaultExtendedTableCssClass)
         {
             $this->tableOptions = array_merge($this->tableOptions, ['class' => 'table table-striped table-bordered table-hover']);
         }
     }

     public function init()
     {
         $this->extendsRowOptions();

         $this->checkIfNeedToAddActionColum();

         // Call parent init()
         parent::init();

         $this->checkIfNeedToEnableRowClickToView();

         $this->checkIfNeedToEnableDefaultExtendedTableCssClass();
     }
 }

 ?>
