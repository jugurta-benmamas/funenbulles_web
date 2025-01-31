<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

<div class="ludique">
    <h1><?= $message ?></h1>
    <?=form_open(base_url().'public/adminPage');?>
    <p id="lesQuestions_btn">
        <?php
        $data=array(
            'name'=>'submit',
            'id'=>'submit',
            'value'=>"Voir les questions");
        echo form_submit($data);
        ?>
    </p>
    <p>
        <?=form_close();?>
    </p>
</div>

<?= $this->endSection(); ?>
