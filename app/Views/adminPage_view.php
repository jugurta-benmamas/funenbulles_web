<?= $this->extend('template_base_view'); ?>
<?= $this->section('content'); ?>

<div class="ludique">
    <h1><?= $titre ?></h1>

    <div class='configAdmin'>
        <p>
            <?= form_button(['onclick' => "window.location.href='" . base_url('public/ajouter') . "'"], "Ajouter une question") ?>
        </p>
    </div>

    <!-- Formulaire de recherche -->
    <div>
        <?= form_open(base_url().'public/adminPage') ?>
        <p>
            <?php
            $data = array(
                'name' => 'motCle',
                'id' => 'motCle',
                'placeholder' => 'Une question....',
                'value' => set_value('motCle'),
            );
            echo form_input($data);
            ?>

            <?php
            $data = array(
                'name' => 'submit',
                'id' => 'submit_recherche',
                'value' => 'Rechercher',
            );
            echo form_submit($data);
            ?>
        </p>
        <?= form_close(); ?>
    </div>

    <?php
    if (empty($lesQuestions)):
        echo "<h3>Aucune question trouvée</h3>";
    else:
        ?>
        <table>
            <thead>
            <tr>
                <th>Id</th>
                <th>Questions</th>
                <th>Themes</th>
                <th>Images</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Affichage des résultats de recherche
            foreach ($lesQuestions as $questions):
                ?>
                <tr>
                    <td><?= $questions->question_id ?></td>
                    <td>
                        <?php
                        if (isset($questions->question_libelle)) {
                            echo anchor(base_url().'public/modifier/'.$questions->question_id, $questions->question_libelle);
                        } else {
                            echo 'Libellé inconnu';
                        }
                        ?>
                    </td>
                    <td><?= $questions->question_theme ?></td>
                    <td><?= $questions->question_image ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>



        </table>
    <?php endif; ?>
</div>

<?= $this->endSection(); ?>
