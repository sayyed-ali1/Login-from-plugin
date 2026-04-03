# 🔐 Custom Login & User Dashboard Plugin (WordPress)

A lightweight custom WordPress plugin that provides a **custom login system, user dashboard, profile editing, and user-specific data management** using AJAX.

---

## 🚀 Features

* 🔐 Custom Login Form (AJAX-based)
* 🚪 Logout Button
* 👤 User Dashboard (Frontend)
* ✏️ Edit Profile (Name & Email)
* 📋 User-Specific Form Entries
* ⚡ AJAX-based interactions (no page reload)
* 🔒 Secure (Nonce + User validation)

---

## 📂 Plugin Structure

```
plugin-folder/
│
├── includes/
│   └── functions.php
│
├── assets/
│   └── login.js
│
└── main-plugin-file.php
```

---

## 🛠️ Installation

1. Download or clone this repository
2. Upload the plugin folder to:

   ```
   /wp-content/plugins/
   ```
3. Go to WordPress Admin → Plugins
4. Activate the plugin

---

## 🧩 Usage

### 🔑 Login Form

Use this shortcode on any page:

```
[mylogin]
```

---

### 📊 User Dashboard

Create a page and add:

```
[mydashboard]
```

👉 This will show:

* User info (name, email)
* Profile edit form
* User-specific entries
* Logout button

---

### 🚪 Logout Button

```
[mylogout]
```

---

## ⚙️ How It Works

### 🔹 Login System

* Uses `wp_signon()` for authentication
* AJAX-based login (no page reload)
* Redirects user after successful login

---

### 🔹 Dashboard

* Uses `wp_get_current_user()` to fetch user data
* Displays personalized content
* Restricts access for non-logged-in users

---

### 🔹 Profile Update

* AJAX request updates:

  * Name
  * Email
* Uses `wp_update_user()`

---

### 🔹 User Entries

* Stores form data in custom DB table
* Each entry linked with `user_id`
* Users can only view their own data

---

## 🔒 Security

* Nonce verification (`check_ajax_referer`)
* User authentication checks
* Data sanitization:

  * `sanitize_text_field`
  * `sanitize_email`
  * `sanitize_textarea_field`

---

## 💡 Future Improvements

* ✏️ Edit & Delete Entries
* 📁 File Upload System
* 🖼️ Profile Image Upload
* 🔐 Change Password Feature
* 🎨 UI Enhancement (Bootstrap)

---

## 🧑‍💻 Author

**Syed Ali**
Frontend & WordPress Developer

---

## 🌐 Live Demo

*(Add your live link here after deployment)*

---

## 📌 Notes

* Built as a learning project for custom WordPress plugin development
* Demonstrates real-world features like user dashboard and AJAX handling

---

⭐ If you like this project, consider giving it a star!
