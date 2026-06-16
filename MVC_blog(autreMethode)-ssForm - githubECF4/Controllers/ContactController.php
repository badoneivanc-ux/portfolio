<?php

namespace App\Controllers;

/**
 * Contrôleur de la page Contact.
 * Gère l'affichage du formulaire de contact et le traitement de l'envoi.
 */
class ContactController extends Controller
{
    /**
     * Affiche la page de contact avec le formulaire vide.
     * Route : index.php?controller=contact&action=index
     */
    public function index(): void
    {
        // On rend la vue contact/index sans données supplémentaires
        $this->render('contact/index');
    }

    /**
     * Traite la soumission du formulaire de contact.
     * Valide les champs puis affiche un message de confirmation ou d'erreur.
     * Route : index.php?controller=contact&action=send (POST)
     */
    public function send(): void
    {
        // Tableau pour stocker les erreurs de validation
        $errors = [];

        // Récupération et nettoyage des champs POST (déjà nettoyés par Controller::protected_values)
        $nom     = $this->paramPost['nom']     ?? '';
        $email   = $this->paramPost['email']   ?? '';
        $sujet   = $this->paramPost['sujet']   ?? '';
        $message = $this->paramPost['message'] ?? '';

        // --- Validation ---

        // Le nom est obligatoire
        if (empty($nom)) {
            $errors['nom'] = 'Le nom est obligatoire.';
        }

        // L'email est obligatoire et doit être valide
        if (empty($email)) {
            $errors['email'] = "L'adresse e-mail est obligatoire.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'adresse e-mail n'est pas valide.";
        }

        // Le sujet est obligatoire
        if (empty($sujet)) {
            $errors['sujet'] = 'Le sujet est obligatoire.';
        }

        // Le message est obligatoire et doit faire au moins 10 caractères
        if (empty($message)) {
            $errors['message'] = 'Le message est obligatoire.';
        } elseif (mb_strlen($message) < 10) {
            $errors['message'] = 'Le message doit contenir au moins 10 caractères.';
        }

        if (!empty($errors)) {
            // Des erreurs existent : on réaffiche le formulaire avec les erreurs et les valeurs saisies
            $this->render('contact/index', [
                'errors'  => $errors,
                'nom'     => $nom,
                'email'   => $email,
                'sujet'   => $sujet,
                'message' => $message,
            ]);
        } else {
            // Aucune erreur : on affiche un message de confirmation
            $this->render('contact/index', [
                'success' => true,
                'nom'     => $nom,
            ]);
        }
    }
}
