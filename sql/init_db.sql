-- Create tables
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(255),
    last_name VARCHAR(255),
    phone_number VARCHAR(20),
    created_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    updated_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3)
);

CREATE TABLE categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) UNIQUE NOT NULL,
    created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3)
);

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    category_id INT,
    image_url TEXT NOT NULL,
    sku VARCHAR(255) NOT NULL UNIQUE,
    stock_quantity INT DEFAULT 0,
    created_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3),
    updated_at DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3),
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE SET NULL
);

CREATE TABLE inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    stock_quantity INT NOT NULL,
    last_updated DATETIME(3) DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3),
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE product_reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL,
    comment TEXT NOT NULL,
    created_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    CONSTRAINT unique_review UNIQUE (product_id, user_id)
);

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(12,2) NOT NULL,
    order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method ENUM('credit_card', 'debit_card', 'paypal', 'apple_pay', 'google_pay') DEFAULT 'credit_card',
    created_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    updated_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(12,2) GENERATED ALWAYS AS (quantity * price) STORED,
    created_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

CREATE TABLE form_submissions (
    submission_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(50) NOT NULL,
    reason ENUM('General_Inquiry', 'Pricing', 'Product_Info', 'Shipping', 'Other') NOT NULL,
    message TEXT NOT NULL,
    product_id INT,
    submitted_at DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);

-- Inserting data (copied from other project, fix)
INSERT INTO categories (category_name) VALUES 
("Tops"), 
("Amigurumi"), 
("Bags");

INSERT INTO products (name, description, price, category_id, image_url, sku, stock_quantity) 
VALUES("Aria Bralette Top", 
"This Simple Summer Crochet Kit includes everything you need to create your own comfortable and stylish Aria Bralette Top." , 
10.99, 
1, 
"/assets/images/product-1.jpg", 
"SMR-TOP-001",
10);

INSERT INTO products (name, description, price, category_id, image_url, sku, stock_quantity) 
VALUES("Totoro", 
"This Adorable Amigurumi Crochet Kit includes everything you need to create your own adorable and squishy Totoro Amigurumi toy." , 
12.99, 
2, 
"/assets/images/product-2.jpg", 
"SML-AMI-001",
20);

INSERT INTO products (name, description, price, category_id, image_url, sku, stock_quantity) 
VALUES("Leila Mesh Pullover", 
"This Simple Summer Crochet Kit includes everything you need to create your own comfortable and stylish Leila Mesh Pullover." , 
12.99, 
1, 
"/assets/images/product-3.jpg", 
"SMR-TOP-002",
10);

INSERT INTO products (name, description, price, category_id, image_url, sku, stock_quantity) 
VALUES("Elena Book Bag", 
"This Practically Soft Crochet Kit includes everything you need to create your own lightweight and stylish Elena Book Bag." , 
14.99, 
3, 
"/assets/images/product-4.jpg", 
"CRO-BAG-001",
10);

INSERT INTO inventory (product_id, stock_quantity) VALUES
(1, 10), 
(2, 20), 
(3, 10), 
(4, 10);

-- INSERT INTO product_reviews (product_id, user_id, rating, comment)
-- VALUES(1, 1, 5, "So comfortable and so easy to make! Took me less than 2 hours and I've been wearing it ever since!");