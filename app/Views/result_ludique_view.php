<?= $this->extend('template_base_view'); ?>

<?= $this->section('content'); ?>

<div class="ludiqueResult">
<h1>Résultat du Quiz</h1>

    <div class="score-container">
        <p class="score-message">Ton score :</p>
        <div class="score-box">
            <?= $score ?> ⭐
        </div>
    </div>
    <h2><?= $message ?></h2>
    <div class="questions-container">
        <?php if (!empty($questionsOk)): ?>
            <?php foreach ($questionsOk as $question): ?>
                <div class="question-card">
                    <div class="question-header">
                        <h3>Question :</h3>
                        <p><?= $question->question ?></p>
                    </div>
                    <div class="question-body">
                        <p><strong>Votre réponse :</strong> <?= $question->reponse ?></p>
                    </div>
                    <div class="question-footer">
                        <p class="correct-label">Bonne réponse !</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Dommage, Aucune question n'a trouvé sa bonne réponse, N'hésite pas à recommencer.</p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection(); ?>
