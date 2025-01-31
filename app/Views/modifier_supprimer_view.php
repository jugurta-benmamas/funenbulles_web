<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

<div class="ludique">
    <h1><?= $titre ?></h1>
    <?= form_open(base_url().'public/modifierQuestion/'.$question_id)?>

    <p>ID de la question : <?php echo $question_id?></p>

    <p>
        <?= form_label('Libelle de la question : ', 'libelle');
        $data = array(
            'name' => 'libelle',
            'id' => 'libelle',
            'size' => '100%',
            'value' => $libelle, // Remplir avec la valeur de la question
        );
        echo form_input($data);
        echo '</p><p class="erreurs">';
        echo isset($validation) ? $validation->getError('libelle') : '';
        ?>
    </p>

    </p>
    <p>
        <?= form_label('Theme de la question : ', 'theme')?>

        <?php if (!empty($themes)): ?>
            <?php foreach ($themes  as $index => $theme): ?>
                <?php
                // Préparer les données pour chaque case à cocher
                $data = array(
                    'name' => 'theme[]',  // Permet de sélectionner plusieurs thèmes
                    'id' => 'theme_' . $theme,  // Utilisation de $theme->theme pour l'ID
                    'value' => $theme,  // Utilisation de $theme->theme pour la valeur
                    'checked' => in_array($theme, (array)$question->theme),  // Si le thème est dans les thèmes sélectionnés, cochez la case
                    'class' => 'theme-checkbox-ajout'
                );
                echo form_radio($data) . " <span>" . $theme . "</span>";
                ?>
            <?php endforeach; ?>
        <?php else: echo "aucun theme"; ?>
        <?php endif; ?>

    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('theme') : '';

        ?>
    </p>
    <p>
        <?= form_label('Image : ', 'image');
        $data = array(
            'name' => 'image',
            'id' => 'image',
            'size'=> '50%',
            'placeholder'=>'Facultatif',
            'value' => $image,
        );
        echo form_input($data);
        ?>
    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('image') : '';
        ?>
    </p>
    <hr>
    <p>
        <?= form_label('Proposition réponse 1 : ', 'prop1');
        $data = array(
            'name' => 'prop1',
            'id' => 'prop1',
            'size'=> '30%',
            'value' => $prop1,
        );
        echo form_input($data);
        ?>
        <?php
        // Initialiser les données pour la proposition 1 - Correct
        $data = array(
            'name' => 'prop1_correct',
            'id' => 'prop1_oui',
            'value' => '1',  // "oui" correspond à correct (1)
            'checked' => ($est_correct_1 == 1),  // Coche "Correct" si est_correct_1 == 1
            'class' => 'question-radio',
        );
        echo form_radio($data) . " Correct ";

        // Initialiser les données pour la proposition 1 - Incorrect
        $data['id'] = 'prop1_non';
        $data['value'] = '0';  // "non" correspond à incorrect (0)
        $data['checked'] = ($est_correct_1 == 0);  // Coche "Incorrect" si est_correct_1 == 0
        echo form_radio($data) . " Incorrect ";
        ?>


    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('prop1') : '' ?>
        <?php echo isset($validation) ? $validation->getError('prop1_correct') : ''; ?>
    </p>

    <p>
        <?= form_label('Proposition réponse 2 : ', 'prop2');
        $data = array(
            'name' => 'prop2',
            'id' => 'prop2',
            'size'=> '30%',
            'value' => $prop2,
        );
        echo form_input($data);
        ?>
        <?php
        $data = array(
            'name' => 'prop2_correct',
            'id' => 'prop2_oui',
            'value' => '1',  // "oui" correspond à correct (1)
            'checked' => ($est_correct_2 == 1),
            'class' => 'question-radio'
        );
        echo form_radio($data) . " Correct ";

        $data['id'] = 'prop2_non';
        $data['value'] = '0';  // "non" correspond à incorrect (0)
        $data['checked'] = ($est_correct_2 == 0);  // Marquer comme incorrect si "non"
        echo form_radio($data) . " Incorrect ";  // Marquer comme incorrect si "non"
        ?>
    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('prop2') : ''; ?>
        <?php echo isset($validation) ? $validation->getError('prop2_correct') : ''; ?>
    </p>
    <p>
        <?= form_label('Proposition réponse 3 : ', 'prop3');
        $data = array(
            'name' => 'prop3',
            'id' => 'prop3',
            'size'=> '30%',
            'value' => $prop3,
        );
        echo form_input($data);
        ?>
        <?php
        $data = array(
            'name' => 'prop3_correct',
            'id' => 'prop3_oui',
            'value' => '1',  // "oui" correspond à correct (1)
            'checked' => $est_correct_3 == 1,
            'class' => 'question-radio'
        );
        echo form_radio($data) . " Correct ";

        $data['id'] = 'prop3_non';
        $data['value'] = '0';  // "non" correspond à incorrect (0)
        $data['checked'] =$est_correct_3 == 0;  // Marquer comme incorrect si "non"
        echo form_radio($data) . " Incorrect ";  // Marquer comme incorrect si "non"
        ?>
    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('prop3') : '';
        ?>
    </p>

    <p>
        <?= form_label('Proposition réponse 4 : ', 'prop4');
        $data = array(
            'name' => 'prop4',
            'id' => 'prop4',
            'size'=> '30%',
            'value' => $prop4,
        );
        echo form_input($data);
        ?>
        <?php
        $data = array(
            'name' => 'prop4_correct',
            'id' => 'prop4_oui',
            'value' => '1',  // "oui" correspond à correct (1)
            'checked' => $est_correct_4 == 1,
            'class' => 'question-radio'
        );
        echo form_radio($data) . " Correct ";

        $data['id'] = 'prop4_non';
        $data['value'] = '0';  // "non" correspond à incorrect (0)
        $data['checked'] = $est_correct_4 == 0;  // Marquer comme incorrect si "non"
        echo form_radio($data) . " Incorrect ";  // Marquer comme incorrect si "non"
        ?>
    </p>
    <p class="erreurs">
        <?php echo isset($validation) ? $validation->getError('prop4') : '';
        ?>
    </p>
    <hr>

    <?php
    $data = array(
        'name' => 'submit',
        'id' => 'submit_modifier',
        'value' => 'Modifier'
    );
    echo form_submit($data);
    ?>


    <?= form_close();?>


    <?=form_open(base_url().'public/supprimerQuestion/'.$question_id)?>
    <?php
    $data = array(
        'name' => 'submit',
        'id' => 'submit_supprimer',
        'value' => 'Supprimer'
    );
    echo form_submit($data);
    ?>

    <?=form_close();?>

</div>




<?= $this->endSection(); ?>
