-- PostgreSQL Database Schema for Devrim Tuncer Website
-- Run this file in PostgreSQL to create all tables

-- ============================================
-- 1. Users Table
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 2. Password Reset Tokens Table
-- ============================================
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- ============================================
-- 3. Failed Jobs Table
-- ============================================
CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) NOT NULL UNIQUE,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 4. Personal Access Tokens Table
-- ============================================
CREATE TABLE IF NOT EXISTS personal_access_tokens (
    id BIGSERIAL PRIMARY KEY,
    tokenable_type VARCHAR(255) NOT NULL,
    tokenable_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL UNIQUE,
    abilities TEXT NULL,
    last_used_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 5. Languages Table
-- ============================================
CREATE TABLE IF NOT EXISTS languages (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(2) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    native_name VARCHAR(255) NOT NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    is_default BOOLEAN NOT NULL DEFAULT false,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 6. Blog Categories Table
-- ============================================
CREATE TABLE IF NOT EXISTS blog_categories (
    id BIGSERIAL PRIMARY KEY,
    name_tr VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description_tr TEXT NULL,
    description_en TEXT NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 7. Blog Tags Table
-- ============================================
CREATE TABLE IF NOT EXISTS blog_tags (
    id BIGSERIAL PRIMARY KEY,
    name_tr VARCHAR(255) NOT NULL,
    name_en VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 8. Blogs Table
-- ============================================
CREATE TABLE IF NOT EXISTS blogs (
    id BIGSERIAL PRIMARY KEY,
    category_id BIGINT NULL,
    title_tr VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    excerpt_tr TEXT NULL,
    excerpt_en TEXT NULL,
    content_tr TEXT NOT NULL,
    content_en TEXT NOT NULL,
    featured_image VARCHAR(255) NULL,
    meta_title_tr VARCHAR(255) NULL,
    meta_title_en VARCHAR(255) NULL,
    meta_description_tr TEXT NULL,
    meta_description_en TEXT NULL,
    meta_keywords_tr VARCHAR(255) NULL,
    meta_keywords_en VARCHAR(255) NULL,
    reading_time INTEGER NULL,
    view_count INTEGER NOT NULL DEFAULT 0,
    is_active BOOLEAN NOT NULL DEFAULT true,
    is_featured BOOLEAN NOT NULL DEFAULT false,
    sort_order INTEGER NOT NULL DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_blogs_category FOREIGN KEY (category_id) REFERENCES blog_categories(id) ON DELETE SET NULL
);

-- ============================================
-- 9. Blog Tag Pivot Table
-- ============================================
CREATE TABLE IF NOT EXISTS blog_tag_pivot (
    id BIGSERIAL PRIMARY KEY,
    blog_id BIGINT NOT NULL,
    tag_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_blog_tag_pivot_blog FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE,
    CONSTRAINT fk_blog_tag_pivot_tag FOREIGN KEY (tag_id) REFERENCES blog_tags(id) ON DELETE CASCADE,
    CONSTRAINT unique_blog_tag UNIQUE (blog_id, tag_id)
);

-- ============================================
-- 10. Portfolios Table
-- ============================================
CREATE TABLE IF NOT EXISTS portfolios (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    company VARCHAR(255) NULL,
    type VARCHAR(255) NOT NULL,
    description_tr TEXT NULL,
    description_en TEXT NULL,
    service_type VARCHAR(255) NULL,
    image VARCHAR(255) NULL,
    link VARCHAR(255) NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    completed_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 11. Portfolio Tools Table
-- ============================================
CREATE TABLE IF NOT EXISTS portfolio_tools (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    icon VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 12. Portfolio Tool Pivot Table
-- ============================================
CREATE TABLE IF NOT EXISTS portfolio_tool_pivot (
    id BIGSERIAL PRIMARY KEY,
    portfolio_id BIGINT NOT NULL,
    tool_id BIGINT NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_portfolio_tool_pivot_portfolio FOREIGN KEY (portfolio_id) REFERENCES portfolios(id) ON DELETE CASCADE,
    CONSTRAINT fk_portfolio_tool_pivot_tool FOREIGN KEY (tool_id) REFERENCES portfolio_tools(id) ON DELETE CASCADE,
    CONSTRAINT unique_portfolio_tool UNIQUE (portfolio_id, tool_id)
);

-- ============================================
-- 13. Tools Table
-- ============================================
CREATE TABLE IF NOT EXISTS tools (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    url VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 14. Slides Table
-- ============================================
CREATE TABLE IF NOT EXISTS slides (
    id BIGSERIAL PRIMARY KEY,
    title_tr VARCHAR(255) NULL,
    title_en VARCHAR(255) NULL,
    text_tr TEXT NULL,
    text_en TEXT NULL,
    image_desktop VARCHAR(255) NOT NULL,
    image_mobile VARCHAR(255) NOT NULL,
    link VARCHAR(255) NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 15. Messages Table
-- ============================================
CREATE TABLE IF NOT EXISTS messages (
    id BIGSERIAL PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    ip_address VARCHAR(255) NULL,
    is_read BOOLEAN NOT NULL DEFAULT false,
    read_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 16. Experiences Table
-- ============================================
CREATE TABLE IF NOT EXISTS experiences (
    id BIGSERIAL PRIMARY KEY,
    job_title VARCHAR(255) NOT NULL,
    company VARCHAR(255) NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    description_tr TEXT NULL,
    description_en TEXT NULL,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 17. Education Table
-- ============================================
CREATE TABLE IF NOT EXISTS education (
    id BIGSERIAL PRIMARY KEY,
    institution VARCHAR(255) NOT NULL,
    degree VARCHAR(255) NOT NULL,
    field_of_study VARCHAR(255) NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    description_tr TEXT NULL,
    description_en TEXT NULL,
    achievement VARCHAR(255) NULL,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 18. Settings Table
-- ============================================
CREATE TABLE IF NOT EXISTS settings (
    id BIGSERIAL PRIMARY KEY,
    key VARCHAR(255) NOT NULL UNIQUE,
    value TEXT NULL,
    type VARCHAR(255) NOT NULL DEFAULT 'text',
    description TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 19. Page Views Table
-- ============================================
CREATE TABLE IF NOT EXISTS page_views (
    id BIGSERIAL PRIMARY KEY,
    page_path VARCHAR(255) NOT NULL,
    ip_address VARCHAR(255) NOT NULL,
    user_agent VARCHAR(255) NULL,
    referer VARCHAR(255) NULL,
    language VARCHAR(255) NULL,
    viewed_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Create indexes for page_views
CREATE INDEX IF NOT EXISTS idx_page_views_path_ip_date ON page_views(page_path, ip_address, viewed_at);
CREATE INDEX IF NOT EXISTS idx_page_views_viewed_at ON page_views(viewed_at);

-- ============================================
-- 20. Audit Logs Table
-- ============================================
CREATE TABLE IF NOT EXISTS audit_logs (
    id BIGSERIAL PRIMARY KEY,
    user_id BIGINT NULL,
    action VARCHAR(255) NOT NULL,
    model_type VARCHAR(255) NULL,
    model_id BIGINT NULL,
    description TEXT NULL,
    old_values JSONB NULL,
    new_values JSONB NULL,
    ip_address VARCHAR(255) NULL,
    user_agent VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_audit_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Create indexes for audit_logs
CREATE INDEX IF NOT EXISTS idx_audit_logs_user_created ON audit_logs(user_id, created_at);
CREATE INDEX IF NOT EXISTS idx_audit_logs_model ON audit_logs(model_type, model_id);
CREATE INDEX IF NOT EXISTS idx_audit_logs_action ON audit_logs(action);

-- ============================================
-- 21. Sitemap Cache Table
-- ============================================
CREATE TABLE IF NOT EXISTS sitemap_cache (
    id BIGSERIAL PRIMARY KEY,
    sitemap_content TEXT NOT NULL,
    last_updated TIMESTAMP NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- 22. Galleries Table
-- ============================================
CREATE TABLE IF NOT EXISTS galleries (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    tag VARCHAR(255) NULL,
    image VARCHAR(255) NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN NOT NULL DEFAULT true,
    sort_order INTEGER NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ============================================
-- Indexes for better performance
-- ============================================

-- Users indexes
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);

-- Blogs indexes
CREATE INDEX IF NOT EXISTS idx_blogs_slug ON blogs(slug);
CREATE INDEX IF NOT EXISTS idx_blogs_category ON blogs(category_id);
CREATE INDEX IF NOT EXISTS idx_blogs_published ON blogs(published_at);
CREATE INDEX IF NOT EXISTS idx_blogs_active ON blogs(is_active);

-- Portfolios indexes
CREATE INDEX IF NOT EXISTS idx_portfolios_slug ON portfolios(slug);
CREATE INDEX IF NOT EXISTS idx_portfolios_type ON portfolios(type);
CREATE INDEX IF NOT EXISTS idx_portfolios_active ON portfolios(is_active);

-- Slides indexes
CREATE INDEX IF NOT EXISTS idx_slides_active ON slides(is_active);
CREATE INDEX IF NOT EXISTS idx_slides_sort ON slides(sort_order);

-- Messages indexes
CREATE INDEX IF NOT EXISTS idx_messages_email ON messages(email);
CREATE INDEX IF NOT EXISTS idx_messages_read ON messages(is_read);
CREATE INDEX IF NOT EXISTS idx_messages_created ON messages(created_at);

-- Tools indexes
CREATE INDEX IF NOT EXISTS idx_tools_slug ON tools(slug);
CREATE INDEX IF NOT EXISTS idx_tools_active ON tools(is_active);

-- Portfolio Tools indexes
CREATE INDEX IF NOT EXISTS idx_portfolio_tools_slug ON portfolio_tools(slug);

-- Galleries indexes
CREATE INDEX IF NOT EXISTS idx_galleries_tag ON galleries(tag);
CREATE INDEX IF NOT EXISTS idx_galleries_active ON galleries(is_active);

-- ============================================
-- End of Schema
-- ============================================

-- ============================================
-- Initial Data: Admin User
-- ============================================
-- Admin kullanıcı oluştur
-- Email: admin@devrimtuncer.com
-- Password: (hash ile şifrelenmiş)
INSERT INTO users (name, email, password, email_verified_at, created_at, updated_at)
VALUES (
    'Admin',
    'admin@devrimtuncer.com',
    '$2y$10$QqxSr4F6Ra7rRuU08IUCh.2ATPpyKVJmhm1YsZmmtlAgBb6G.2F6m',
    NOW(),
    NOW(),
    NOW()
)
ON CONFLICT (email) DO NOTHING;

-- ============================================
-- Initial Data: Languages
-- ============================================
INSERT INTO languages (code, name, native_name, is_active, is_default, sort_order, created_at, updated_at)
VALUES 
    ('tr', 'Turkish', 'Türkçe', true, true, 1, NOW(), NOW()),
    ('en', 'English', 'English', true, false, 2, NOW(), NOW())
ON CONFLICT (code) DO NOTHING;

-- ============================================
-- Initial Data: Settings
-- ============================================
INSERT INTO settings (key, value, type, description, created_at, updated_at)
VALUES 
    ('instagram_url', '', 'text', 'Instagram URL', NOW(), NOW()),
    ('twitter_url', '', 'text', 'Twitter URL', NOW(), NOW()),
    ('r10_url', '', 'text', 'R10 URL', NOW(), NOW()),
    ('fiverr_url', '', 'text', 'Fiverr URL', NOW(), NOW()),
    ('linkedin_url', '', 'text', 'LinkedIn URL', NOW(), NOW()),
    ('phone', '', 'text', 'Phone Number', NOW(), NOW()),
    ('whatsapp', '', 'text', 'WhatsApp Number', NOW(), NOW()),
    ('email', 'info@devrimtuncer.com', 'text', 'Email Address', NOW(), NOW()),
    ('cv_file', '', 'file', 'CV File', NOW(), NOW()),
    ('location_address', '', 'text', 'Location Address', NOW(), NOW()),
    ('location_map_url', '', 'text', 'Location Map URL', NOW(), NOW()),
    ('vision_tr', 'Teknoloji ile hayatı kolaylaştırmak ve dijital dönüşümde öncü olmak.', 'text', 'Vision (Turkish)', NOW(), NOW()),
    ('vision_en', 'To make life easier with technology and be a pioneer in digital transformation.', 'text', 'Vision (English)', NOW(), NOW()),
    ('mission_tr', 'Kaliteli, hızlı ve güvenilir yazılım çözümleri sunarak müşterilerimizin başarısına katkıda bulunmak.', 'text', 'Mission (Turkish)', NOW(), NOW()),
    ('mission_en', 'To contribute to our customers'' success by providing quality, fast and reliable software solutions.', 'text', 'Mission (English)', NOW(), NOW()),
    ('why_me_tr', '• Hızlı Teslimat: Projelerinizi zamanında teslim ediyorum.
• Ödeme Sistemi: Ürünü teslim etmeden ödeme almıyoruz.
• Ürünün Arkasındayız: Teslim sonrası da destek sağlıyoruz.
• 7/24 Destek: Her zaman yanınızdayız.', 'text', 'Why Me (Turkish)', NOW(), NOW()),
    ('why_me_en', '• Fast Delivery: I deliver your projects on time.
• Payment System: We don''t take payment before delivering the product.
• We Stand Behind Our Product: We provide support after delivery.
• 24/7 Support: We are always with you.', 'text', 'Why Me (English)', NOW(), NOW())
ON CONFLICT (key) DO NOTHING;

-- ============================================
-- End of Initial Data
-- ============================================

