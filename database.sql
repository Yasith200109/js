CREATE DATABASE IF NOT EXISTS js_constructions CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE js_constructions;

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS settings (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  icon VARCHAR(80) DEFAULT 'building-2',
  description TEXT NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS projects (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  category VARCHAR(100) NOT NULL,
  project_status ENUM('Completed','Ongoing') NOT NULL DEFAULT 'Completed',
  location VARCHAR(190) NULL,
  completed_year VARCHAR(10) NULL,
  area_sqft DECIMAL(12,2) NULL,
  description TEXT NOT NULL,
  cover_image VARCHAR(500) NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('draft','published') NOT NULL DEFAULT 'published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS project_images (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  project_id INT UNSIGNED NOT NULL,
  image_path VARCHAR(500) NOT NULL,
  caption VARCHAR(190) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  CONSTRAINT fk_project_images_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS house_designs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  category VARCHAR(100) NOT NULL,
  bedrooms INT NOT NULL DEFAULT 3,
  bathrooms INT NOT NULL DEFAULT 2,
  floors INT NOT NULL DEFAULT 1,
  area_sqft DECIMAL(12,2) NOT NULL DEFAULT 0,
  land_size VARCHAR(120) NULL,
  estimated_cost VARCHAR(150) NULL,
  description TEXT NOT NULL,
  image VARCHAR(500) NULL,
  is_featured TINYINT(1) NOT NULL DEFAULT 0,
  status ENUM('draft','published') NOT NULL DEFAULT 'published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS gallery (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(190) NOT NULL,
  category VARCHAR(100) NOT NULL,
  image_path VARCHAR(500) NOT NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS testimonials (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  client_name VARCHAR(150) NOT NULL,
  location VARCHAR(150) NULL,
  quote TEXT NOT NULL,
  rating TINYINT NOT NULL DEFAULT 5,
  sort_order INT NOT NULL DEFAULT 0,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quotations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  phone VARCHAR(60) NOT NULL,
  email VARCHAR(190) NULL,
  location VARCHAR(190) NULL,
  service VARCHAR(190) NOT NULL,
  project_type VARCHAR(120) NULL,
  budget VARCHAR(120) NULL,
  message TEXT NULL,
  status ENUM('New','Contacted','Site Visit','Quoted','Closed') NOT NULL DEFAULT 'New',
  admin_notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact_messages (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NULL,
  phone VARCHAR(60) NULL,
  subject VARCHAR(190) NULL,
  message TEXT NOT NULL,
  status ENUM('New','Read','Replied','Closed') NOT NULL DEFAULT 'New',
  admin_notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO admins (name,email,password) VALUES
('Website Administrator','admin@jsconstructions.lk','$2y$12$OtxZ7uSzMDoWN855aHmDEeT.6uT9IJfK2PPY5ic2TGMGzs7v1FD6a')
ON DUPLICATE KEY UPDATE name=VALUES(name);

INSERT INTO settings (setting_key,setting_value) VALUES
('company_name','J & S Constructions'),
('tagline','Build Your Dream House'),
('founded_year','1995'),
('phone_1','075 089 6076'),
('phone_2','077 077 0671'),
('whatsapp','94750896076'),
('email','jsconstructions@gmail.com'),
('website','jsconstructions.lk'),
('address','Sri Lanka'),
('company_description','J & S Constructions is a trusted construction company delivering quality, reliable, and efficient building solutions for residential, commercial, and infrastructure projects.'),
('meta_description','Trusted residential, commercial and infrastructure construction services in Sri Lanka since 1995.'),
('site_url',''),
('facebook',''),
('instagram',''),
('youtube','')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);

INSERT INTO services (title,icon,description,sort_order,is_active) VALUES
('Residential Construction','house','Complete home construction services from site preparation and structural work to final finishes and handover.',1,1),
('Commercial Construction','building-2','Professional construction solutions for offices, retail spaces, warehouses and other commercial developments.',2,1),
('Infrastructure Projects','landmark','Reliable execution support for selected infrastructure and civil construction requirements.',3,1),
('Architectural Planning','drafting-compass','Practical design coordination, space planning and drawing support aligned with client needs and site conditions.',4,1),
('Renovations & Extensions','hammer','Carefully managed upgrades, additions and improvements that bring new value to existing buildings.',5,1),
('Interior Construction','sofa','Functional and refined interior construction, partitioning, ceilings, finishes and customized spaces.',6,1),
('Project Management','clipboard-check','Planning, coordination, supervision, progress tracking and quality control across the construction process.',7,1),
('Construction Consultation','messages-square','Early-stage guidance on feasibility, scope, priorities, budgeting considerations and next steps.',8,1);

INSERT INTO projects (title,slug,category,project_status,location,completed_year,area_sqft,description,cover_image,is_featured,status) VALUES
('Contemporary Family Residence','contemporary-family-residence','Residential','Completed','Colombo','2025',2850,'A bright contemporary family residence designed around open living, natural light and practical everyday comfort. The project balances modern exterior lines with warm interior finishes and carefully coordinated spaces.','library/project-contemporary-family-residence.jpg',1,'published'),
('Modern Two-Storey Home','modern-two-storey-home','Residential','Completed','Gampaha','2024',3200,'A spacious two-storey home with a clean modern façade, generous family areas and a layout designed for privacy and flexibility.','library/project-modern-two-storey-home.jpg',1,'published'),
('Premium Office Interior','premium-office-interior','Commercial','Completed','Negombo','2025',1800,'A polished commercial interior focused on efficient circulation, collaborative work zones and a professional client-facing atmosphere.','library/project-premium-office-interior.jpg',1,'published'),
('Luxury Villa Development','luxury-villa-development','Residential','Ongoing','Kurunegala','2026',4100,'An ongoing luxury villa development combining strong contemporary architecture, landscaped outdoor areas and premium finishes.','library/project-luxury-villa.jpg',0,'published'),
('Retail Space Renovation','retail-space-renovation','Commercial','Completed','Colombo','2023',1400,'A complete retail renovation that transformed an existing space into a brighter, more efficient and customer-friendly environment.','library/project-retail-space-renovation.jpg',0,'published');

INSERT INTO projects (title,slug,category,project_status,location,completed_year,area_sqft,description,cover_image,is_featured,status) VALUES
('Commercial Business Center','commercial-business-center','Commercial','Completed','Colombo','2025',5200,'A contemporary commercial development designed for flexible business use, efficient circulation and a confident professional street presence.','library/project-commercial-building.jpg',1,'published'),
('Community Infrastructure Upgrade','community-infrastructure-upgrade','Infrastructure','Ongoing','Western Province','2026',0,'An infrastructure improvement project coordinated around safe execution, practical site access, durable civil work and structured progress management.','library/project-infrastructure.jpg',0,'published');


INSERT INTO project_images (project_id,image_path,caption,sort_order)
SELECT id,'library/gallery-premium-interior.jpg','Premium living and dining interior',1 FROM projects WHERE slug='contemporary-family-residence'
UNION ALL SELECT id,'library/gallery-construction-detail.jpg','Carefully executed construction detail',2 FROM projects WHERE slug='contemporary-family-residence'
UNION ALL SELECT id,'library/house-custom-family-haven.jpg','Contemporary exterior inspiration',3 FROM projects WHERE slug='contemporary-family-residence'
UNION ALL SELECT id,'library/house-azure-residence.jpg','Modern two-storey exterior concept',1 FROM projects WHERE slug='modern-two-storey-home'
UNION ALL SELECT id,'library/house-urban-compact-home.jpg','Urban façade and space planning',2 FROM projects WHERE slug='modern-two-storey-home'
UNION ALL SELECT id,'library/gallery-premium-interior.jpg','Warm family interior finish',3 FROM projects WHERE slug='modern-two-storey-home'
UNION ALL SELECT id,'library/project-office-interior.jpg','Professional office interior',1 FROM projects WHERE slug='premium-office-interior'
UNION ALL SELECT id,'library/gallery-commercial-project.jpg','Commercial workspace detail',2 FROM projects WHERE slug='premium-office-interior'
UNION ALL SELECT id,'library/gallery-planning-studio.jpg','Planning and coordination studio',3 FROM projects WHERE slug='premium-office-interior'
UNION ALL SELECT id,'library/house-grand-courtyard.jpg','Luxury courtyard residence concept',1 FROM projects WHERE slug='luxury-villa-development'
UNION ALL SELECT id,'library/house-custom-family-haven.jpg','Premium residential architecture',2 FROM projects WHERE slug='luxury-villa-development'
UNION ALL SELECT id,'library/gallery-construction-detail.jpg','Ongoing site workmanship',3 FROM projects WHERE slug='luxury-villa-development'
UNION ALL SELECT id,'library/project-commercial-building.jpg','Updated commercial frontage',1 FROM projects WHERE slug='retail-space-renovation'
UNION ALL SELECT id,'library/gallery-commercial-project.jpg','Retail and customer area finish',2 FROM projects WHERE slug='retail-space-renovation'
UNION ALL SELECT id,'library/gallery-premium-interior.jpg','Refined interior detailing',3 FROM projects WHERE slug='retail-space-renovation'
UNION ALL SELECT id,'library/project-office-interior.jpg','Finished office environment',1 FROM projects WHERE slug='commercial-business-center'
UNION ALL SELECT id,'library/gallery-commercial-project.jpg','Commercial development detail',2 FROM projects WHERE slug='commercial-business-center'
UNION ALL SELECT id,'library/gallery-planning-studio.jpg','Project planning and design coordination',3 FROM projects WHERE slug='commercial-business-center'
UNION ALL SELECT id,'library/gallery-construction-detail.jpg','Civil construction progress',1 FROM projects WHERE slug='community-infrastructure-upgrade'
UNION ALL SELECT id,'library/project-commercial-building.jpg','Structural and access coordination',2 FROM projects WHERE slug='community-infrastructure-upgrade'
UNION ALL SELECT id,'library/gallery-planning-studio.jpg','Infrastructure planning support',3 FROM projects WHERE slug='community-infrastructure-upgrade';

INSERT INTO house_designs (title,slug,category,bedrooms,bathrooms,floors,area_sqft,land_size,estimated_cost,description,image,is_featured,status) VALUES
('The Azure Residence','the-azure-residence','Modern Houses',4,3,2,2850,'12 perches or above','On request','A refined two-storey concept with open-plan living, a flexible upstairs family area, four comfortable bedrooms and a strong modern street presence. The layout can be adjusted to suit land shape, access and preferred room sizes.','library/house-azure-residence.jpg',1,'published'),
('Serene Single-Storey','serene-single-storey','Single-Storey Houses',3,2,1,1850,'10 perches or above','On request','A practical single-level home designed for easy movement, natural ventilation and a strong connection between living, dining and garden areas.','library/house-serene-single-storey.jpg',1,'published'),
('The Grand Courtyard','the-grand-courtyard','Luxury Houses',5,5,2,4200,'20 perches or above','On request','A spacious premium residence organized around an internal courtyard, with formal and informal living areas, generous bedrooms and indoor-outdoor entertaining zones.','library/house-grand-courtyard.jpg',1,'published'),
('Urban Compact Home','urban-compact-home','Two-Storey Houses',3,3,2,2100,'8 perches or above','On request','A compact two-storey concept created for urban land, with efficient room placement, a modern façade and practical family spaces.','library/house-urban-compact-home.jpg',0,'published'),
('Custom Family Haven','custom-family-haven','Custom House Designs',4,4,2,3400,'Custom','On request','A flexible family-centered concept that can be reconfigured around lifestyle, land orientation, future expansion and personalized architectural preferences.','library/house-custom-family-haven.jpg',0,'published');

INSERT INTO gallery (title,category,image_path,sort_order,is_active) VALUES
('Modern Residence Exterior','Residential','library/project-contemporary-family-residence.jpg',1,1),
('Premium Living Interior','Interiors','library/gallery-premium-interior.jpg',2,1),
('Contemporary Office','Commercial','library/gallery-commercial-project.jpg',3,1),
('Architectural Planning Studio','Planning','library/gallery-planning-studio.jpg',4,1),
('Two-Storey Architecture','Residential','library/project-modern-two-storey-home.jpg',5,1),
('Construction Detail','Work in Progress','library/gallery-construction-detail.jpg',6,1),
('Commercial Building Exterior','Commercial','library/project-commercial-building.jpg',7,1),
('Infrastructure Development','Infrastructure','library/project-infrastructure.jpg',8,1),
('Luxury Villa Architecture','Residential','library/project-luxury-villa.jpg',9,1),
('Professional Office Interior','Interiors','library/project-office-interior.jpg',10,1),
('Grand Courtyard House','House Designs','library/house-grand-courtyard.jpg',11,1),
('Serene Single-Storey Home','House Designs','library/house-serene-single-storey.jpg',12,1);

INSERT INTO testimonials (client_name,location,quote,rating,sort_order,is_active) VALUES
('Kasun Perera','Colombo','J & S Constructions completed our home with excellent attention to detail. The quality of work and communication throughout the project were highly professional.',5,1,1),
('Nadeesha Fernando','Gampaha','We are very satisfied with the construction service provided by J & S Constructions. The project was managed efficiently and completed according to our expectations.',5,2,1),
('Tharindu & Sewwandi','Negombo','From the initial planning stage to the final handover, the team supported us throughout the entire process. They successfully turned our dream home into a reality.',5,3,1),
('Dilshan Jayawardena','Kurunegala','A trustworthy construction company with professional service, quality workmanship and clear communication. We highly recommend J & S Constructions.',5,4,1);
