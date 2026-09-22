USE js_constructions;

-- Add two additional sample portfolio projects.
INSERT INTO projects (title,slug,category,project_status,location,completed_year,area_sqft,description,cover_image,is_featured,status) VALUES
('Commercial Business Center','commercial-business-center','Commercial','Completed','Colombo','2025',5200,'A contemporary commercial development designed for flexible business use, efficient circulation and a confident professional street presence.','library/project-commercial-building.jpg',1,'published'),
('Community Infrastructure Upgrade','community-infrastructure-upgrade','Infrastructure','Ongoing','Western Province','2026',0,'An infrastructure improvement project coordinated around safe execution, practical site access, durable civil work and structured progress management.','library/project-infrastructure.jpg',0,'published')
ON DUPLICATE KEY UPDATE title=VALUES(title),category=VALUES(category),project_status=VALUES(project_status),location=VALUES(location),completed_year=VALUES(completed_year),area_sqft=VALUES(area_sqft),description=VALUES(description),cover_image=VALUES(cover_image),is_featured=VALUES(is_featured),status=VALUES(status);

-- Refresh the sample project galleries with multiple images.
DELETE pi FROM project_images pi
INNER JOIN projects p ON p.id=pi.project_id
WHERE p.slug IN (
  'contemporary-family-residence','modern-two-storey-home','premium-office-interior',
  'luxury-villa-development','retail-space-renovation','commercial-business-center',
  'community-infrastructure-upgrade'
);

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

-- Expand the public gallery with the bundled image library.
DELETE FROM gallery;
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
