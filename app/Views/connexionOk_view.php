<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

<div class="admin">
    <?php
    echo isset($validation) ? $validation->listErreurs() : "";?>

    <?php
    if(session()->get('login')):
        ?>
        <h1>Bonjour <?php
            echo session()->get('prenom').' '.session()->get('nom');
            ?></h1>

        <?=form_open(base_url().'public/adminPage');?>
        <p>
            <?php
            $data=array(
                'name'=>'submit',
                'id'=>'submit',
                'value'=>"Acceder à l'espace ludique");
            echo form_submit($data);
            ?>
        </p>
        <p>
            <?=anchor(base_url().'public/deconnexion', "Se deconnecter");?>
        </p>
        <p>
            <?=form_close();?>
        </p>


        <?php
        else:
            ?>
            <div id="mess_deconnexion">
                <h2> Vous êtes déconnecté !</h2>
            </div>
        <?php
        endif;
        ?>

</div>
<?= $this->endSection(); ?>
