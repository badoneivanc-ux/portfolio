# ============================================================
# Dockerfile — Application Portfolio PHP/MVC
# Image de base : php:8.2-apache (PHP 8.2 avec Apache intégré)
# ============================================================

# --- Image de base ---
# On utilise l'image officielle PHP avec Apache embarqué
FROM php:8.2-apache

# --- Variables de build (personnalisables au moment du build) ---
# Répertoire de travail dans le conteneur
ARG APP_DIR=/var/www/html

# --- Installation des extensions PHP nécessaires ---
# pdo_mysql : permet à PHP de communiquer avec MySQL via PDO
# mysqli    : extension MySQL alternative (compatibilité)
RUN docker-php-ext-install pdo_mysql mysqli

# --- Activation des modules Apache ---
# rewrite : permet la réécriture d'URL (utilisé par le routeur MVC)
RUN a2enmod rewrite

# --- Configuration du VirtualHost Apache ---
# On pointe DocumentRoot vers le sous-dossier public/ de l'application
# pour que seul le point d'entrée index.php soit accessible depuis le web
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        # AllowOverride All : autorise la lecture des fichiers .htaccess\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    # Journaux d'\''erreurs et d'\''accès Apache\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# --- Copie du code source ---
# On copie l'intégralité du projet dans le répertoire de travail du conteneur
COPY . ${APP_DIR}

# --- Permissions ---
# www-data est l'utilisateur Apache ; on lui donne accès en lecture/écriture
# sur le dossier images pour l'upload éventuel de fichiers
RUN chown -R www-data:www-data ${APP_DIR} \
    && chmod -R 755 ${APP_DIR}

# --- Port exposé ---
# Apache écoute sur le port 80 à l'intérieur du conteneur
EXPOSE 80
