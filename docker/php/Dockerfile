# =====================================================================
# L'image du service web : Apache + PHP 8.3, avec tout ce dont le
# module aura besoin de la séance 1 à la séance 9.
#
# Vous n'avez pas à modifier ce fichier.
# =====================================================================
FROM php:8.3-apache

# --- Extensions PHP ---------------------------------------------------
# mbstring et readline sont déjà présentes dans l'image officielle.
# On ajoute :
#   pdo_mysql : accès à la base           (séance 2)
#   intl, zip : exigées par Symfony       (séance 6)
#   opcache   : comportement réaliste d'un serveur
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libicu-dev \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install pdo_mysql intl zip opcache \
    && rm -rf /var/lib/apt/lists/*

# --- Réécriture d'URL -------------------------------------------------
# Indispensable au front controller de la séance 5, puis à Symfony.
RUN a2enmod rewrite

# --- LA racine web : public/, et rien d'autre -------------------------
# Apache sert /var/www/html/public. Les dossiers cli/, inc/, data/ et sql/
# sont montés À CÔTÉ : accessibles à votre code, injoignables depuis un
# navigateur. C'est aussi l'organisation que Symfony imposera en séance 6.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Autoriser les .htaccess dans la racine web (front controller, Symfony).
RUN { \
        echo '<Directory ${APACHE_DOCUMENT_ROOT}>'; \
        echo '    AllowOverride All'; \
        echo '</Directory>'; \
    } > /etc/apache2/conf-available/skillswap.conf \
    && a2enconf skillswap

# --- Erreurs visibles -------------------------------------------------
# On veut TOUT voir, avertissements compris : c'est un environnement de
# développement, et lire ses erreurs fait partie du travail.
# Ce réglage n'a rien à faire sur un serveur exposé.
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# --- Composer ---------------------------------------------------------
# Récupéré depuis son image officielle. Servira en séance 3 (autoload)
# puis en séance 6 (installation de Symfony).
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
