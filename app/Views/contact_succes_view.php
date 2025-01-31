<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>
<div class="auteurs">
    <h1><?=$titre?></h1>
</div>
<div>
    <h2>Recap</h2>
    <p>Nom : <?= $_POST['nom'] ?></p>
    <p>Prénom : <?= $_POST['prenom'] ?></p>
    <p>Sujet : <?= $_POST['sujet'] ?></p>
    <p>Message : <?= $_POST['message'] ?></p>
</div>

<?= $this->endSection(); ?>
