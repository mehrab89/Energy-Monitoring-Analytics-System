CREATE DATABASE energy_monitoring;

USE energy_monitoring;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appliances / Consumption Data
CREATE TABLE consumption (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    appliance_name VARCHAR(100),
    usage_hours FLOAT,
    power_rating FLOAT,
    usage_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Predictions Table
CREATE TABLE predictions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    predicted_bill FLOAT,
    prediction_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);