Yii2 GridView Extended
======================
Yii2 GridView Extended

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist fabriziocaldarelli/yii2-gridview-extended "*"
```

or add

```
"fabriziocaldarelli/yii2-gridview-extended": "*"
```

to the require section of your `composer.json` file.

Details
-----

The extension adds these features:
* Handle click on the data row to call controller view route;
* Action column is added by default to show only delete action;


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \sfmobile\ext\gridViewExtended\GridViewExtended::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],

    // 'addActionColumm' => true,       // default is true
    // 'enableRowClickToView' => true,  // default is true
    // 'rowClickViewUrl' => ['view'],   // default is ['view']

    'columns' => [

        // ... columns ...

        // if $addActionColumn is true (default is true), ActionColumn will be inserted by default
        //['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
```
