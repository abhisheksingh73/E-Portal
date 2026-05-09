# 🚀 Textile E-Portal Deployment Guide (Free Tier)

This guide provides step-by-step instructions to deploy your Laravel Textile E-Portal to **Render.com** using a free MySQL database from **Aiven.io**.

---

## 🏗️ Step 1: Prepare Your Code for Production

Before pushing to GitHub, ensure your project is ready for a live environment.

1.  **Environment Variables**: Ensure your `.env` file is NOT pushed to GitHub (it should be in `.gitignore`).
2.  **Build Script**: Create a file named `render-build.sh` in your root directory to automate the setup on Render:
    ```bash
    #!/usr/bin/env bash
    # exit on error
    set -o errexit

    composer install --no-dev --optimize-autoloader

    # Compile assets (if using Vite/NPM)
    # npm install && npm run build

    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
3.  **Web Server Config**: Create a file named `.htaccess` in your root directory (if not present) or ensure your server points to the `public/` folder.

---

## 🗄️ Step 2: Get a Free MySQL Database

Render's free tier does not include a permanent MySQL database. We will use **Aiven** instead.

1.  Go to [Aiven.io](https://aiven.io/) and create a free account.
2.  Create a new **MySQL** service (Choose the **Free Plan**).
3.  Once the service is "Running", copy the following credentials:
    *   **Host** (Service URI)
    *   **Port** (usually 3306)
    *   **User** (usually 'avnadmin')
    *   **Password**
    *   **Database Name** (usually 'defaultdb')

---

## ☁️ Step 3: Deploy to Render.com

1.  Push your code to a **GitHub repository**.
2.  Log in to [Render.com](https://render.com/).
3.  Click **New +** and select **Web Service**.
4.  Connect your GitHub repository.
5.  **Configure the Service**:
    *   **Runtime**: `PHP`
    *   **Build Command**: `bash render-build.sh`
    *   **Start Command**: `herokulike-php-apache2 public/` (Render uses an Apache-like environment for PHP).
6.  **Environment Variables**: Click the **Advanced** tab and add:
    *   `APP_KEY`: (Copy from your local `.env`)
    *   `APP_DEBUG`: `false`
    *   `APP_ENV`: `production`
    *   `DB_CONNECTION`: `mysql`
    *   `DB_HOST`: (Your Aiven Host)
    *   `DB_PORT`: (Your Aiven Port)
    *   `DB_DATABASE`: (Your Aiven DB Name)
    *   `DB_USERNAME`: (Your Aiven User)
    *   `DB_PASSWORD`: (Your Aiven Password)

---

## 🖼️ Step 4: Handling Images (The "Gotcha")

Free platforms like Render have **ephemeral storage**. This means any images uploaded by sellers will disappear whenever the server restarts or you redeploy code.

**Solution for Free Tier:**
Use **Cloudinary** (Free Tier) to store your images instead of your local disk.
1.  Install the Cloudinary Laravel package: `composer require cloudinary-labs/cloudinary-laravel`
2.  Update your `SellerController` and `AdminController` to upload to Cloudinary instead of `Storage::disk('public')`.

---

## 🛠️ Common Post-Deployment Commands

Once deployed, you might need to run migrations. Go to the **Shell** tab in Render and run:
```bash
php artisan migrate --force
```

---

## ✅ Final Verification
1.  Visit your Render URL (e.g., `https://textile-portal.onrender.com`).
2.  Register a new user.
3.  Verify that the database stores the user correctly.
4.  Test the Marketplace and Cart.

---
**Need help with specific errors during deployment? Just ask!**
