# 🏛️ Textile Ministry E-Portal: Technical & Functional Guide

Welcome to the comprehensive guide for your project. This document is structured to help you understand the **Architecture**, **File Mapping**, and **Core Features** in depth. Use this for your study and Viva preparation.

---

## 🚀 1. Technology Stack
*   **Framework:** Laravel 11.x (PHP 8.2+)
*   **Frontend:** Blade Templating Engine, Vanilla CSS (Premium Glassmorphism), JavaScript (AJAX/Fetch)
*   **Database:** MySQL (Relational Database)
*   **Cloud Integration:** Cloudinary API (For high-performance Artisan image hosting)
*   **Icons:** FontAwesome 6 (For professional Ministry-grade iconography)

---

## 🏛️ 2. Architectural Overview (MVC)
The project follows the **Model-View-Controller** pattern:
1.  **Models (`app/Models/`):** Define the data structure and relationships (e.g., An `Inquiry` has many `Messages`).
2.  **Views (`resources/views/`):** The UI layer. Divided by roles: `admin/`, `seller/`, `buyer/`.
3.  **Controllers (`app/Http/Controllers/`):** The logic brain. Processes requests, talks to the database, and returns views.

---

## 🔐 3. Role-Based Access Control (RBAC)
We use a robust Middleware system to secure the portal:
*   **File:** `app/Http/Middleware/RoleMiddleware.php`
*   **Logic:** Checks the `role` column in the `users` table before allowing access to a dashboard.
*   **Routes:** Defined in `routes/web.php` inside protected groups.

---

## 📂 4. Module Breakdown: Features & Files

### 👑 A. Administrator Dashboard (Supervision)
**Focus:** Oversight, User Moderation, and Market Intelligence.
*   **User Management:** `AdminController.php` | `admin/users/index.blade.php`
    *   *Feature:* Approve/Decline Sellers, Role Assignment.
*   **Market Orders:** `AdminController.php` | `admin/orders/index.blade.php`
    *   *Feature:* Monitor all transactions across the platform.
*   **Analytics Intelligence:** `AdminController.php` | `admin/dashboard.blade.php`
    *   *Feature:* Ministry Revenue, Order Volume, and User Growth stats.
*   **Scheme Management:** `AdminController.php` | `admin/schemes/`
    *   *Feature:* Create and manage government benefits for artisans.

### 🎨 B. Seller / Artisan Dashboard (Empowerment)
**Focus:** Product Inventory, Order Fulfillment, and Expert Communication.
*   **Product Management:** `SellerController.php` | `seller/products/`
    *   *Feature:* Upload images to Cloudinary, Price management, Stock status.
*   **Threaded Communication:** `SellerController.php` | `seller/inquiries/index.blade.php`
    *   *Feature:* **[Premium]** Threaded chat modal to reply to buyers.
*   **Order Processing:** `SellerController.php` | `seller/orders/index.blade.php`
    *   *Feature:* Update status to 'Shipped' or 'Delivered'.
*   **Govt Schemes:** `SellerController.php` | `seller/schemes.blade.php`
    *   *Feature:* Apply for Ministry benefits and subsidies.

### 🛍️ C. Buyer Dashboard (Experience)
**Focus:** Heritage Discovery, Shopping, and Support.
*   **Marketplace:** `BuyerController.php` | `buyer/marketplace.blade.php`
    *   *Feature:* Real-time search, Category filtering, One-click "Contact Artisan".
*   **Inquiry History:** `BuyerController.php` | `buyer/inquiries.blade.php`
    *   *Feature:* **[Premium]** Chat-like thread for counter-questions.
*   **Shopping Cart & Wishlist:** `BuyerController.php` | `buyer/cart.blade.php` | `buyer/wishlist.blade.php`
    *   *Feature:* COD payment processing, Stock validation.
*   **Textile Articles:** `BuyerController.php` | `buyer/articles.blade.php`
    *   *Feature:* Educational content about Indian handlooms.

---

## 📊 5. Database Schema & Relationships
Key logic for your technical questions:
*   **One-to-Many:** `User` has many `Products`.
*   **One-to-Many:** `Inquiry` has many `Messages` (Threaded chat logic).
*   **Many-to-Many:** `Cart` / `Wishlist` link `Users` to `Products`.
*   **Order Logic:** An `Order` belongs to a `Buyer` and a `Product`.

---

## ✨ 6. Premium Features (What makes it special?)
1.  **Glassmorphic Design:** Professional, modern UI using backdrop-blur and soft gradients (`index.css`).
2.  **Threaded Messaging:** Real-time chat feel for artisan-buyer communication (`messages` table).
3.  **Cloudinary Integration:** Offloads image storage to a professional CDN for faster loading.
4.  **Activity Logging:** Every major action (like applying for a scheme) is logged in the `activities` table.

---

## 🎓 7. Viva Prep: Top 5 Likely Questions
1.  **Q: How do you prevent a Buyer from accessing the Admin panel?**
    *   *A:* Through **Role-Based Middleware**. We check the user's role in the database before the route is even reached.
2.  **Q: Where is your business logic stored?**
    *   *A:* In the **Controllers**. For example, the pricing and order calculations happen in the `BuyerController@checkout`.
3.  **Q: How did you implement the "Counter-Question" feature?**
    *   *A:* By creating a `messages` table linked to the `inquiries` table. Every new reply is a new row in the `messages` table.
4.  **Q: How do images get stored when an artisan uploads a product?**
    *   *A:* We use a helper in `SellerController` that sends the image to **Cloudinary via their API** and stores only the URL in our MySQL database.
5.  **Q: What is the benefit of the MVC architecture?**
    *   *A:* It separates concerns. I can change the UI (View) without breaking the database logic (Model) or the processing (Controller).

---


