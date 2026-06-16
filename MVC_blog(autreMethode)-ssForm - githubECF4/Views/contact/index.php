<?php
/**
 * Vue de la page Contact.
 * Affiche le formulaire de contact, les erreurs de validation
 * ou le message de succès après envoi.
 *
 * Variables disponibles (injectées par ContactController) :
 *  - $errors  : tableau associatif des erreurs (optionnel)
 *  - $success : booléen true si le formulaire a été envoyé avec succès (optionnel)
 *  - $nom, $email, $sujet, $message : valeurs conservées en cas d'erreur (optionnel)
 */

// Définition du titre de la page (récupéré dans base.php via ob_start)
$title = "Mon portfolio - Contact";
?>

<div class="row justify-content-center mt-4">
    <div class="col-md-8">

        <h2 class="mb-4">Contactez-moi</h2>

        <?php if (!empty($success)) : ?>
            <!-- Message de confirmation affiché après un envoi réussi -->
            <div class="alert alert-success" role="alert">
                Merci <strong><?= htmlspecialchars($nom ?? '') ?></strong>, votre message a bien été envoyé !
                Je vous répondrai dans les plus brefs délais.
            </div>

        <?php else : ?>
            <!-- Formulaire de contact -->
            <form action="index.php?controller=contact&action=send" method="POST" novalidate>

                <!-- Champ Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                        id="nom"
                        name="nom"
                        value="<?= htmlspecialchars($nom ?? '') ?>"
                        placeholder="Votre nom complet"
                        required
                    >
                    <?php if (isset($errors['nom'])) : ?>
                        <!-- Affichage de l'erreur de validation du nom -->
                        <div class="invalid-feedback"><?= $errors['nom'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Champ Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse e-mail <span class="text-danger">*</span></label>
                    <input
                        type="email"
                        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                        id="email"
                        name="email"
                        value="<?= htmlspecialchars($email ?? '') ?>"
                        placeholder="votre@email.com"
                        required
                    >
                    <?php if (isset($errors['email'])) : ?>
                        <!-- Affichage de l'erreur de validation de l'email -->
                        <div class="invalid-feedback"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Champ Sujet -->
                <div class="mb-3">
                    <label for="sujet" class="form-label">Sujet <span class="text-danger">*</span></label>
                    <input
                        type="text"
                        class="form-control <?= isset($errors['sujet']) ? 'is-invalid' : '' ?>"
                        id="sujet"
                        name="sujet"
                        value="<?= htmlspecialchars($sujet ?? '') ?>"
                        placeholder="Objet de votre message"
                        required
                    >
                    <?php if (isset($errors['sujet'])) : ?>
                        <!-- Affichage de l'erreur de validation du sujet -->
                        <div class="invalid-feedback"><?= $errors['sujet'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Champ Message -->
                <div class="mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea
                        class="form-control <?= isset($errors['message']) ? 'is-invalid' : '' ?>"
                        id="message"
                        name="message"
                        rows="6"
                        placeholder="Décrivez votre demande (10 caractères minimum)..."
                        required
                    ><?= htmlspecialchars($message ?? '') ?></textarea>
                    <?php if (isset($errors['message'])) : ?>
                        <!-- Affichage de l'erreur de validation du message -->
                        <div class="invalid-feedback"><?= $errors['message'] ?></div>
                    <?php endif; ?>
                </div>

                <!-- Mention champs obligatoires -->
                <p class="text-muted"><small><span class="text-danger">*</span> Champs obligatoires</small></p>

                <!-- Bouton d'envoi -->
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-1"></i> Envoyer le message
                </button>

            </form>

        <?php endif; ?>

        <!-- Informations de contact complémentaires -->
        <hr class="mt-5">
        <div class="row text-center mt-3 mb-4">
            <div class="col-md-4">
                <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                <p>contact@monportfolio.fr</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-phone fa-2x text-primary mb-2"></i>
                <p>+33 6 00 00 00 00</p>
            </div>
            <div class="col-md-4">
                <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                <p>Paris, France</p>
            </div>
        </div>

    </div>
</div>
