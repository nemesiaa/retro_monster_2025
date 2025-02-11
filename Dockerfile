# ─────────────────────────────────────────────────────────────────────────
# Étape 1 : Build des assets front-end
FROM node:18 as node-builder
WORKDIR /app

# Copier les fichiers package.json et package-lock.json
COPY package.json package-lock.json ./

# Installer les dépendances Node.js
RUN npm install

# Copier le reste du code (y compris tailwind.config.js, resources, etc.)
COPY . ./

# Build des assets front-end (inclut Tailwind CSS)
RUN npm run build


# ─────────────────────────────────────────────────────────────────────────
# Étape 2 : Installer les dépendances PHP + Composer
FROM php:8.3-fpm

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip opcache

# Installer Composer (depuis l'image Composer officielle)
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html
COPY . .

# Copier le build Node (assets front-end)
COPY --from=node-builder /app/public/build /var/www/html/public/build

# Installation des dépendances Laravel
RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p storage/framework/cache
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache


# Permissions pour le cache et le stockage
RUN chmod -R 775 storage bootstrap/cache
RUN chown -R www-data:www-data storage bootstrap/cache

# ► 1) Créer le dossier de destination pour les images
RUN mkdir -p storage/app/public/images

# ► 2) Copier les anciennes images si elles existent
RUN if [ -d "public/images" ]; then \
      cp -r public/images/* storage/app/public/images/ || true; \
    fi

# ► 3) Supprimer l'ancien dossier public/images (il sera remplacé par un lien symbolique)
RUN rm -rf public/images

# ► 4) Créer le lien symbolique vers le stockage Laravel
RUN ln -s /var/www/html/storage/app/public/images /var/www/html/public/images

# ► 5) Vérifier que `APP_KEY` est bien généré (sinon Laravel peut planter)
RUN php artisan key:generate --force || true

# ► 6) Assurer que les migrations sont faites (facultatif mais recommandé)
RUN php artisan migrate --force || true

# Exposer le port 8080 (utilisé par Laravel)
EXPOSE 8080

# Commande de démarrage pour Laravel
CMD php artisan serve --host=0.0.0.0 --port=8080
