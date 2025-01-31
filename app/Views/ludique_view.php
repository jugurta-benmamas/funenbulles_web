<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

<div class=ludique>
    <h1><?= $titre ?></h1>
    <?= form_open(base_url().'public/validerThemeQuestion') ?>
    <p>
        <?= form_label('Thèmes : ', 'theme'); ?>
        <?php if (!empty($themes)): ?>
            <?php foreach ($themes as $theme): ?>
                <?php
                // Préparer les données pour chaque case à cocher
                $data = array(
                    'name' => 'theme[]',  // Permet de sélectionner plusieurs thèmes
                    'id' => 'theme_' . $theme,  // Utilisation de $theme->theme pour l'ID
                    'value' => $theme,  // Utilisation de $theme->theme pour la valeur
                    'checked' => true,  // Si le thème est dans les thèmes sélectionnés, cochez la case
                    'class' => 'theme-checkbox'
                );
                echo form_checkbox($data) . " " . $theme;  // Affiche le nom du thème à côté de la case
                ?>
            <?php endforeach; ?>
        <?php else: echo "aucun theme"; ?>
        <?php endif; ?>
    </p>

    <p>
        <?= form_label('Questions : ', 'question'); ?>

        <?php
        $data = array(
            'name' => 'nb_question',  // Même nom pour que seul un radio soit sélectionné
            'id' => 'question_8',
            'value' => '8',
            'class' => 'question-radio'
        );
        echo form_radio($data,"8",true) . " 8 ";

        $data['id'] = 'question_10';
        $data['value'] = '10';
        echo form_radio($data,"10",false) . " 10 ";

        $data['id'] = 'question_12';
        $data['value'] = '12';
        echo form_radio($data,"12",false) . " 12 ";

        $data['id'] = 'question_14';
        $data['value'] = '14';
        echo form_radio($data,"14",false) . " 14 ";

        $data['id'] = 'question_16';
        $data['value'] = '16';
        echo form_radio($data,"16",false) . " 16 ";
        ?>
    </p>

    <p>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => 'Valider');
        echo form_submit($data);
        ?>
    </p>
    <?= form_close() ?>


    <?= form_open(base_url() . 'public/validerRep');
    $questioncourante = "";
    $radio_id = 1;
    foreach ($questions as $question):
    if ($questioncourante != $question->question):
    if ($questioncourante == ""):
    ?>
<div class='question-block'>
<?php else : ?>
</div>
    <div class='question-block'>
        <?php
        endif;
        $questioncourante = $question->question;
        ?>
        <p><?= $question->question; ?></p>
        <?php if (!empty($question->image)) : ?>
            <div class='question-image'>
                <?php
                $image = [
                    'src' => '/public/assets/images/questions/' . esc($question->image) . '.jpg',
                    'alt' => esc($question->question),
                    'title' => esc($question->question). ' (' . esc($question->theme) . ')'
                ];
                echo img($image);
                ?>
            </div>
        <?php endif; ?>
        <?php endif;
        $radio_id = 'reponse_' . $radio_id;
        $data = array(
            'name' => $question->id,
            'id' => $radio_id,
            'value' => $question->reponse);
        ?>
        <span>
            <?= form_radio($data); ?>
            <?= form_label($question->reponse, $radio_id); ?>
        </span>
        <?php
        $radio_id++;
        endforeach;
        ?>
    </div>
    <p>
        <?php
        $data = array(
            'name' => 'submit',
            'id' => 'submit',
            'value' => 'Valider');
        echo form_submit($data);
        ?>
    </p>
    <?= form_close(); ?>

    <?= $this->endSection(); ?>


