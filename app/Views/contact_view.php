<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>
    <div class="auteurs">
        <h1><?=$titre?></h1>
    </div>
<div class="corps_contact">
    <?= form_open(base_url().'public/contactValider')?>
    <p>
        <?= form_label('Nom', 'nom');
        $data = array(
            'name' => 'nom',
            'id' => 'nom',
            'value' => set_value('nom'),
        );
        echo form_input($data);
        ?>
    </p>
    <p>
        <?= form_label('Prenom', 'prenom');
        $data = array(
            'name' => 'prenom',
            'id' => 'prenom',
            'value' => set_value('prenom'),
        );
        echo form_input($data);
        ?>
    </p>
    <p>
        <?= form_label('Sujet', 'sujet');
        $data = array(
            'name' => 'sujet',
            'id' => 'sujet',
            'value' => set_value('sujet'),
        );
        echo form_input($data);
        ?>
    </p>

    <p>
        <?= form_label('Message', 'message');
        echo "<br>";
        $data = array(
            'name' => 'message',
            'id' => 'message',
            'value' => set_value('message'),
            'col' => '60',
            'row' => '10'
        );
        echo form_textarea($data);
        ?>
    </p>

        <?php
        $data = array(
                'name' => 'submit',
            'id' => 'submit',
            'value' => 'Envoyer'
        );
        echo form_submit($data);
        ?>
   <?= form_close();?>
</div>


<?= $this->endSection(); ?>