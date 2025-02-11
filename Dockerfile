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

# Copier le build Node
COPY --from=node-builder /app/public/build /var/www/html/public/build

RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# ► 1) Créer le dossier de destination
RUN mkdir -p storage/app/public/images

# ► 2) Copier les anciennes images (si le dossier public/images existe)
RUN if [ -d "public/images" ]; then \
      cp -r public/images/* storage/app/public/images/ || true; \
    fi

# ► 3) Supprimer l'ancien dossier public/images
RUN rm -rf public/images

# ► 4) Créer le lien symbolique
RUN ln -s /var/www/html/storage/app/public/images /var/www/html/public/images

# ► 5) (Optionnel) php artisan storage:link
RUN php artisan storage:link || true

EXPOSE 8080

# Commande de démarrage pour Laravel
CMD  php artisan serve --host=0.0.0.0 --port=$PORT
