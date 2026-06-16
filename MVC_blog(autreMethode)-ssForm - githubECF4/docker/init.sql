-- ============================================================
-- Script d'initialisation de la base de données Portfolio
-- Exécuté automatiquement par MySQL au premier démarrage
-- du conteneur Docker (via docker-entrypoint-initdb.d/)
-- ============================================================

-- Sélection de la base de données créée via MYSQL_DATABASE
USE Portfolio;

-- ============================================================
-- Création de la table "creation"
-- Stocke les créations/projets du portfolio
-- ============================================================
CREATE TABLE IF NOT EXISTS `creation` (
    -- Identifiant unique auto-incrémenté
    `id_creation` INT          NOT NULL AUTO_INCREMENT,
    -- Titre de la création (100 caractères max)
    `title`       VARCHAR(100) NOT NULL,
    -- Description longue de la création
    `description` LONGTEXT     NOT NULL,
    -- Date et heure de création
    `created_at`  DATETIME     NOT NULL,
    -- Chemin relatif vers l'image associée
    `picture`     VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_creation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- ============================================================
-- Données d'exemple (fixtures)
-- ============================================================
INSERT INTO `creation` (`title`, `description`, `created_at`, `picture`) VALUES
(
    'Projet Web Portfolio',
    'Application web MVC développée en PHP natif. Gestion de créations avec CRUD complet, page de contact avec validation serveur et architecture MVC sans framework.',
    NOW(),
    'images/default.jpg'
),
(
    'Application Mobile',
    'Application mobile responsive développée avec Bootstrap 5. Interface adaptée aux smartphones et tablettes avec navigation intuitive.',
    NOW(),
    'images/default.jpg'
),
(
    'API REST PHP',
    'API RESTful développée en PHP avec authentification JWT, gestion des ressources en JSON et documentation Swagger.',
    NOW(),
    'images/default.jpg'
);
