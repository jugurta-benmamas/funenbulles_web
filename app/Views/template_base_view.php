<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title> <!-- Le titre change en fonction de la page -->
    <?= link_tag('/public/assets/css/style_funbulles.css?v=34.0'); ?>
</head>
<body>
<!-- Bandeau contenant le logo et le titre -->
<header>

    <div class="bandeau">
        <div class="logo">
            <?php
            $image = ['src' => '/public/assets/images/logo_funBulles_couleur.png',
                'alt' => 'FunEnBulles Logo'];
            //echo img($image);
            echo anchor(base_url().'public/',img($image));
            ?>
        </div>
        <!-- Barre noire pour le texte et le menu -->
        <div class="menu-bar">
                <div class="texte-au-dessus">
                    <h1>Du Fun avec des Bulles , des Bulles en Têtes</h1>
                </div>
                <!-- Menu -->
                <nav>
                    <ul class="menu">
                        <li><?= anchor(base_url().'public/', 'ACCUEIL') ?></li>
                        <li><?= anchor(base_url().'public/expositions', 'EXPOSITION(S)') ?></li>
                        <li><?= anchor(base_url().'public/auteurs', 'LES AUTEUR(E)S 2025') ?></li>
                        <li><?= anchor(base_url().'public/espace_ludique', 'ESPACE LUDIQUE') ?></li>
                        <?php
                        if(session()->get('login')):
                            ?><li><?= anchor(base_url().'public/adminPage', 'ESPACE ADMIN') ?></li><?php
                        endif;
                        ?>
                        <li><?= anchor(base_url().'public/pratique', 'INFOS PRATIQUES') ?></li>
                        <li><?= anchor(base_url().'public/contact', 'CONTACT') ?></li>
                    </ul>
                </nav>
        </div>
    </div>


</header>
<main>
    <?= $this->renderSection('content'); ?>
    <div>
    <button id="retourHaut" title="Retour en haut">↑</button>
    <!-- Association du JavaScript -->
    <script src="<?= base_url('/public/assets/js/bouton_top.js'); ?>"></script>
    </div>
</main>

<footer>
    <div class="footer-content">
        <div class="footer-logo">
            <?php
            $image = ['src' => '/public/assets/images/Societe_Logo.png',
                'alt' => 'Geek 4 Fun Logo'];
            echo img($image);
            ?>
        </div>
        <p>&copy; Développé par <span>GEEK_4_FUN</span> 2024-2025. Tous droits réservés.
            <?php
            if(!session()->get('login')):
            ?>
                <?= anchor(base_url().'public/admin', 'Connexion') ?>
            <?php
            endif;
            ?>
            <?php
            if(session()->get('login')):
            ?>
                <?=anchor(base_url().'public/deconnexion', "Se deconnecter") ?>
            <?php
            endif;
            ?><br>

            <?= anchor(base_url().'public/mentionsLegales', 'Mentions Légales.') ?></p><br>
    </div>
</footer>
</body>
</html>
