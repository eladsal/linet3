<?php $form=kartik\form\ActiveForm::begin(array(
	'id'=>'item-template-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->field($model,'name',array('class'=>'span5','maxlength'=>255)); ?>

        <?php
        $models = Itemcategory::find()->All();
        $list = \yii\helpers\ArrayHelper::map($models, 'id', 'name');
        $options=array ( "class"=>'span5','id'=>ucfirst($this->id).'_Itemcategory_id');
        $select=\yii\helpers\Html::dropDownList(ucfirst($this->id).'[Itemcategory_id]', 0, $list, $options );
        
        ?>
            <label for="ItemTemplate_Itemcategory_id" class="required">Item Category <span class="required">*</span></label>
        <?php echo $select; ?>
            <?php //echo $form->field($model,'AccType_id',array('class'=>'span5')); 
            if (isset($items)) {

    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('app', 'Add new'),
        'type' => 'success',
        'options' => array(
            'onclick' => '$("#addnew").dialog("open"); return false;',
        //'data-toggle' => 'modal',
        //'data-target' => '#addnew',
        ),
    ));



    echo app\widgets\GridView::widget( array(
        'id' => 'acc-templateItem-grid',
        'dataProvider' => $items->search(),
        'filter' => $items,
        'columns' => array(
            //'id',
            //array(
            //  'name' => 'AccTemplate_id',
            //   'value' => '$data->AccTemplate->name',   //where name is Client model attribute 
            // ),

            array(
                'name' => 'eavFields_id',
                'value' => '$data->EavFields->name', //where name is Client model attribute 
            ),
            //'',
            array(
                'class' => 'yii\grid\ActionColumn',
                'template' => '{remove}',
                'buttons' => array(
                    'remove' => array(
                        'label' => '<i class="glyphicon glyphicon-remove"></i>',
                        'url' => '$data->id',
                        'options' => array(
                            'onclick' => 'deleteTempItm(this);return false;',
                        ),
                    ),
                ),
            ),
        ),
    ));
}
?>



            
            


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'success',
			'label'=>$model->isNewRecord ? Yii::t('app',"Create") : Yii::t('app',"Save"),
		)); ?>
	</div>

<?php app\widgets\MiniForm::end(); ?>

            
            <?php
echo \yii\jui\Dialog::begin(array(
    'id' => 'addnew',
    'options' => array(
        'title' => Yii::t('app', 'Add new field'),
        'autoOpen' => false,
        'width' => '600px',
    ),
)); //bootstrap.widgets.TbModal

$form = kartik\form\ActiveForm::begin( array(
    'id' => 'newField',
    'options' => array('class' => 'well'),
    'action' => array('SaveSub', 'id' => $model->id),
        )
);
?>

<div class="modal-body">
<?php
$models = EavFields::find()->All();
$list = \yii\helpers\ArrayHelper::map($models, 'id', 'name');
$options = array();

$select = \yii\helpers\Html::dropDownList(ucfirst($this->id) . 'Item[eavFields_id]', 0, $list, $options);
echo $select;
?>
    <input type='hidden' value='<?php echo $model->id; ?>' name='<?php echo ucfirst($this->id); ?>Item[ItemTemplate_id]'>

</div>

<div class="modal-footer">



<?php
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType' => 'submit',
    'type' => 'success',
    'label' => Yii::t('app', 'Submit')
));
?>

    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('app', 'Close'),
        'url' => '#',
        'options' => array(
            'onclick' => '$("#addnew").dialog("close"); return false;',
        //'data-dismiss' => 'modal'
        ),
    ));
    ?>
</div>

    <?php
    \yii\jui\Dialog::end();

    app\widgets\MiniForm::end();
    ?>

<script type="text/javascript">
     function deleteTempItm(obj){//obj
        //var id = obj.getAttribute("href");
        //var id = 1;
        var id = obj.getAttribute("href");
        $.post( "<?php echo yii\helpers\BaseUrl::base().('/itemTemplateItem/delete');?>/"+id,{  }, function( data ) {
            //alert( "Data Loaded: " + data );
            //console.log(data);
            //$('#answerAreaForm').html(data);
            window.location = "<?php echo yii\helpers\BaseUrl::base().('/itemTemplate/update/'.$model->id);?>";
            
          });
        
    }
    
    </script>