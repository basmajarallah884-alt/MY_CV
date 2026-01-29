-- Create Database
CREATE DATABASE IF NOT EXISTS portfolio_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_db;

-- Profile Table
CREATE TABLE IF NOT EXISTS profile (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    job_title VARCHAR(100),
    bio TEXT,
    email VARCHAR(100),
    phone VARCHAR(50),
    location VARCHAR(100),
    age INT, -- Added Age
    avatar VARCHAR(255)
);

-- Initialize Profile with Dummy Data (to avoid empty page)
INSERT INTO profile (full_name, job_title, bio, email, phone, location)
SELECT 'Your Name', 'Full Stack Developer', 'Write a short bio about yourself here...', 'email@example.com', '+1234567890', 'City, Country'
WHERE NOT EXISTS (SELECT 1 FROM profile);

-- Skills Table
CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) NOT NULL,
    type ENUM('hard', 'soft', 'tool') DEFAULT 'hard',
    percentage INT DEFAULT 100
);

-- Projects Table
CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    video VARCHAR(255), -- Added video support
    link VARCHAR(255),
    technologies VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site Settings (Hero Section & General)
CREATE TABLE IF NOT EXISTS settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(50) UNIQUE NOT NULL,
    setting_value TEXT
);

-- Initialize Default Settings if not exist
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES 
('hero_title', 'MINGALAR PAR'),
('hero_subtitle', 'LOREM IPSUM DOLOR SIT AMET...'),
('hero_bg', 'default_bg.jpg'),
('profile_img', 'default_profile.jpg'),
('about_years', '5'),
('about_text', 'Passionate developer...');


-- Certificates Table
CREATE TABLE IF NOT EXISTS certificates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    issuer VARCHAR(100),
    issue_date DATE,
    image VARCHAR(255),
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Social Links
CREATE TABLE IF NOT EXISTS socials (
    id INT PRIMARY KEY AUTO_INCREMENT,
    platform VARCHAR(50), 
    url VARCHAR(255),
    icon_class VARCHAR(50) 
);

-- Contact Messages
CREATE TABLE IF NOT EXISTS messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- About Stats Boxes
CREATE TABLE IF NOT EXISTS stats (
    id INT PRIMARY KEY AUTO_INCREMENT,
    icon VARCHAR(50), -- FontAwesome class
    number VARCHAR(50), -- e.g. "5+", "12"
    label VARCHAR(100), -- e.g. "Years Experience"
    ordering INT DEFAULT 0
);

-- Default Stats
INSERT INTO stats (icon, number, label, ordering) VALUES 
('fas fa-certificate', '5', 'Certifications', 1),
('fas fa-code', '5+', 'Years Coding', 2),
('fas fa-layer-group', '12+', 'Completed Projects', 3),
('fas fa-book', '10+', 'Subjects Learned', 4);

-- Additional Settings Keys (Insert if not exist)
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES 
('contact_title', 'Let\'s work together!'),
('contact_text', 'I am currently available for freelance projects...');

