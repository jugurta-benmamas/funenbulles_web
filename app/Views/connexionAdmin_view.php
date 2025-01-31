<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

    <div class="admin">

        <?php
        use Config\Services;
        $session=Services::session();
        if(!$session->getFlashdata('infoConnexion')):
            ?>
            <h1><?= $titre ?></h1>
        <?php else: ?><h1>
            <?=$session->getFlashdata('infoConnexion');?>
            </h1>
        <?php
        endif;?>
        <?=form_open(base_url().'public/connexion')?>
        <p>
            <?= form_label('Login : ', 'login');
            $data=array(
                'name'=>'login',
                'id'=>'login',
                'value'=>set_value('login'),
                'minlenght'=>3,
                'size'=>20);
            echo form_input($data);?>
        </p>
        <p class="erreurs">
            <?php echo $validation->getError('login');
            ?>
        </p>
        <p>
            <?= form_label('Mot de Passe : ', 'motPasse');
            $data=array(
                'name'=>'motPasse',
                'id'=>'motPasse',
                'value'=>set_value('motPasse'),
                'minlenght'=>12,
                'size'=>20);
            echo form_password($data);
            echo'</p><p class="erreurs">';
            echo isset($validation) ? $validation->getError('motPasse') : '';

            ?>
        </p>
        <p>
            <?php
            $data=array(
                'name'=>'submit',
                'id'=>'submit',
                'value'=>'Valider');
            echo form_submit($data);
            ?>

            <?=form_close()?>
        </p>

    </div>
<?= $this->endSection(); ?>