# Make Order Service

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE.md)

## Overview

This repository contains the backend service for making order. The service is powered by Laravel Octane, PostgresSQL, and Redis, adhering to a Domain-Oriented Architecture inspired by Domain Oriented architecture.

# Project Structure

This repository follows a structured organization to maintain a clear separation of concerns between the application and domain layers. The project is built with Laravel and consists of the following key directories:

## Directory Structure

```plaintext
src/
|-- App/
|   |-- Order/
|   |   |-- Visitor/
|   |   |   |-- ViewModel/
|   |   |   |-- Lang/
|   |   |   |-- Requests/
|   |   |   |-- Tests/
|   |   |   |-- ViewModel/
|   |   |-- ...
|-- Domain/
|   |-- Models/
|   |-- Order/
|   |   |-- Actions/
|   |   |-- DataTransferObjects/
|   |   |-- Jobs/
|   |   |-- Mail/
|   |   |-- Resources/
|   |   |-- Tests/
|   |   |-- ...
|-- Support/
```

## Domains

### 1. Make Order

- **Description:**
  Responsible for handling place order.
- **Key Components:**
    - `MakeOrderAction`
- **Technology:**
  Utilizes Laravel Octane for efficient request handling.

### 2. Database Interaction

- **Description:**
  PostgresSQL is the primary database for storing order and user information.
- **Technology:**
  Eloquent ORM for streamlined database interactions.

### 3. Caching and Queueing

- **Description:**
  Redis is employed for caching and Laravel Queues for asynchronous processing of tasks.
- **Technologies:**
    - Redis for caching
    - Laravel Queues for background processing

## Technologies Used

- **Laravel Octane:** Enhances performance with Swoole for efficient HTTP request handling.
- **PostgresSQL:** A reliable and scalable relational database.
- **Redis:** Used for caching and Queueing.

## Getting Started

1. **Clone the repository:**
   ```bash
   git clone git@github.com:YoussefAshraf397/make-order-service.git

2. **Run via docker:**
   ```bash
   docker-compose up -d --build
   ```

3. **Run terminal of foodics-app docker container:**
   ```bash
    docker exec -it foodics-app bash
      ```

4. **Run migration inside container:**
   ```bash
    php artisan migrate
      ```

5. **Run seeder to fill data inside container:**
   ```bash
    php artisan db:seed --class=Database\\Seeders\\FoodicsTaskSeeder
      ```
   
6. **Once the server is running, you can make a POST request to the following endpoint:**
   ```bash
   http://localhost:8860/api/v1/ar/visitor/order/make-order
   ```

7. **Request body:**
   ```bash
   {
    "products": [
        {
            "product_id": 1,
            "quantity": 1
        }
    ]
   }
   ```

# Conclusion

Thank you for exploring make-order-service! We hope this README provides a clear understanding of the project structure and how to run it locally. If you have any questions, encounter issues, or want to contribute, feel free to reach out or open an issue.

Happy coding!

---

**make-order-service - Youssef Ashraf Awad**
