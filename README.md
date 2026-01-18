# 🕶️ AI Eyeglasses Store

## Introduction
AI Eyeglasses Store is an AI-powered eyewear e-commerce website that integrates face shape recognition and virtual try-on technology to help users choose eyeglasses that best suit their facial features.

The system combines traditional online shopping with Artificial Intelligence, providing a more personalized and interactive shopping experience.

---

## Features

### Customer
- User authentication (register, login, logout)
- View product list and product details
- Search eyeglasses by product name
- Shopping cart management (add, update, remove)
- Checkout with Cash on Delivery (COD)
- View order history and order details
- Upload face image for AI face shape recognition
- Receive eyeglasses recommendations based on face shape
- Virtual eyeglasses try-on

### Admin
- Admin authentication and dashboard
- Product management (add, edit, activate/deactivate)
- Order management (view orders, update order status)
- User management

---

## System Implementation Results

### Register
![Register](public/images/Demo/Register%20screen.png)

*Figure 3.1 Register page*

The registration page allows users to create a new account by entering basic information such as full name, email, password, and password confirmation.

---

### Login
![Login](public/images/Demo/Login%20screen.png)

*Figure 3.2 Login page*

The login page allows users and administrators to access the system using their registered credentials.

---

### Home
![Home](public/images/Demo/Home%20screen.png)

*Figure 3.3 Home page*

The home page displays banners, featured products, search functionality, and product categories for easy navigation.

---

### Product List
![Product page](public/images/Demo/Product%20page%20screen.png)

*Figure 3.4 Product list page*

This page displays all available eyeglasses with images, names, prices, and availability.

---

### Product Detail
![Product detail page](public/images/Demo/Product%20detail%20page%20screen.png)

*Figure 3.5 Product detail page*

The product detail page provides detailed information including product description, price, images, reviews, and add-to-cart functionality.

---

### Glasses Recommendation
![Glasses suggest page](public/images/Demo/Glasses%20suggest%20page%20screen.png)

*Figure 3.6 Glasses recommendation page*

Based on the detected face shape, the system recommends suitable eyeglasses models to the user.

---

### Face Shape Recognition
![Face shape recognition Page](public/images/Demo/Face%20shape%20recognition%20Page%20screen.png)
![Face shape recognition Page](public/images/Demo/Face%20shape%20recognition%20Page%20screen2.png)


*Figure 3.7 Face shape recognition page*

Users upload a facial image, and the AI model classifies the face shape into predefined categories such as oval, round, square, heart, or oblong.

---

### Virtual Try-On
![Virtual Try-On Page](public/images/Demo/Virtual%20Try-On%20Page%20screen.png)
![Virtual Try-On Page](public/images/Demo/Virtual%20Try-On%20Page%20screen2.png)


*Figure 3.8 Virtual try-on page*

The virtual try-on feature allows users to preview eyeglasses directly on their facial images for a more realistic shopping experience.

---

### Cart
![Cart page](public/images/Demo/Cart%20page%20screen.png)

*Figure 3.9 Cart page*

The cart page allows users to manage selected products, update quantities, and view the total order amount.

---

### Checkout
![Checkout page](public/images/Demo/Checkout%20page%20screen.png)

*Figure 3.10 Checkout page*

Users enter shipping information, choose a payment method, and confirm their orders on this page.

---

### Orders
![Order page](public/images/Demo/Order%20page%20screen.png)

*Figure 3.11 Order page*

This page displays the list of orders placed by the user along with order status and total amount.

---

### Order Detail
![Order detail page](public/images/Demo/Order_detail_page_screen.png)
![Order detail page](public/images/Demo/Order_detail_page_screen2.png)


*Figure 3.12 Order detail page*

The order detail page shows detailed information about products, quantities, prices, and shipping status.

---

### Admin Dashboard
![Admin home page](public/images/Demo/Admin%20home%20page%20screen.png)

*Figure 3.13 Admin dashboard*

The admin dashboard provides an overview of users, products, and orders in the system.

---

### User Management
![User management page](public/images/Demo/User%20management%20page%20screen.png)

*Figure 3.14 User management page*

Administrators can view, add, edit, or delete user accounts on this page.

---

### Product Management
![Product management page](public/images/Demo/Product%20management%20page%20screen.png)

*Figure 3.15 Product management page*

This page allows administrators to manage product information including name, price, images, and descriptions.

---

### Order Management
![Order management page](public/images/Demo/Order%20management%20page%20screen.png)
![Order management page](public/images/Demo/Order%20management%20page%20screen2.png)


*Figure 3.16 Order management page*

Administrators can view order details and update order statuses to ensure accurate order processing.

---

## Technology Stack
- PHP – Backend web development
- Python (Flask) – AI service and API
- CNN (MobileNetV2) – Face shape recognition model
- MySQL – Relational database
- HTML, CSS, JavaScript – Frontend
- OpenCV / Dlib – Image processing and facial landmark detection

---

## Project Purpose
This project applies Artificial Intelligence to an eyewear e-commerce system, improving user experience through personalized recommendations and virtual try-on functionality.
