# Coolify ile PHP Projesi Deployment Rehberi

Bu rehber, Coolify platformunda PHP projelerini deploy etmek için gereken tüm dosyaları ve yapılandırmaları içerir. Bu dokümantasyon genel bir rehberdir ve tüm PHP projelerinde kullanılabilir.

## 📋 İçindekiler

1. [Gerekli Dosyalar](#gerekli-dosyalar)
2. [Environment Variables](#environment-variables)
3. [Config Dosyaları](#config-dosyaları)
4. [Router Yapılandırması](#router-yapılandırması)
5. [Web Server Yapılandırması](#web-server-yapılandırması)
6. [Coolify Deployment](#coolify-deployment)
7. [Troubleshooting](#troubleshooting)

---

## 📁 Gerekli Dosyalar

Coolify'de PHP projesi deploy etmek için aşağıdaki dosyalar gereklidir:

### 1. `Procfile`
PHP built-in server'ı başlatmak için kullanılır. Nixpacks otomatik olarak bu dosyayı kullanır.

```procfile
web: php -S 0.0.0.0:3000 -t /app
```

**Açıklama:**
- `0.0.0.0`: Tüm network interface'lerde dinle
- `3000`: Port numarası (Coolify'de genellikle 3000 kullanılır)
- `/app`: Uygulama root dizini (Coolify'de genellikle `/app`)

### 2. `.env-example`
Environment variables için örnek dosya. Bu dosyayı `.env` olarak kopyalayıp değerleri doldurun.

```env
# Veritabanı Ayarları
DB_HOST=localhost
DB_PORT=3306
DB_NAME=your_database
DB_USER=your_user
DB_PASS=your_password

# Site Ayarları
SITE_URL=https://yourdomain.com
CONTACT_EMAIL=info@yourdomain.com

# Uygulama Modu
APP_ENV=production
DEBUG_MODE=false

# Admin Paneli
ADMIN_PATH=/admin

# Dosya Yükleme Limitleri (MB)
MAX_UPLOAD_SIZE=5
ALLOWED_IMAGE_TYPES=jpg,jpeg,png,gif,webp

# Sayfalama
BLOGS_PER_PAGE=9
SERVICES_PER_PAGE=12

# Sosyal Medya
WHATSAPP_NUMBER=905551234567
INSTAGRAM_URL=https://www.instagram.com/your_account/
VIDEO_URL=https://www.youtube.com/embed/VIDEO_ID
GOOGLE_MAPS_URL=https://maps.app.goo.gl/YOUR_MAP_ID

# Çalışma Saatleri
WORKING_HOURS=Pazartesi - Cuma: 09:00 - 17:30 | Cumartesi: 09:00 - 14:00 | Pazar: Kapalı
```

**Coolify'de Kullanım:**
- Coolify'de Environment Variables bölümüne gidin
- Yukarıdaki değişkenleri ekleyin
- Değerlerinizi girin
- `.env` dosyasına gerek yok, Coolify otomatik olarak environment variables'ı yükler

### 3. `Caddyfile` (Opsiyonel - Caddy kullanıyorsanız)
Caddy reverse proxy için yapılandırma dosyası.

```caddyfile
# Caddyfile for Coolify
# This file is automatically used by Coolify when Caddy is selected

# Default site - catch all
:80 {
    root * /app
    
    # Static files
    @static {
        path *.jpg *.jpeg *.png *.gif *.ico *.css *.js *.svg *.woff *.woff2 *.ttf *.eot *.webp *.xml *.txt *.pdf
        path /assets/*
    }
    
    # Admin panel
    @admin {
        path /admin/*
    }
    
    # Handle static files - query string ile cache-busting
    handle @static {
        file_server
        # Query string varsa cache'i bypass et, yoksa uzun cache
        header Cache-Control "public, max-age=31536000, immutable"
        # Query string ile isteklerde cache'i bypass et
        @has_query {
            query *
        }
        header @has_query Cache-Control "public, max-age=0, must-revalidate"
    }
    
    # Handle admin panel
    handle @admin {
        try_files {path} {path}/ /admin/index.php
        reverse_proxy localhost:3000
    }
    
    # Handle clean URLs - route to index.php
    handle {
        try_files {path} /index.php
        reverse_proxy localhost:3000
    }
}

# Security headers
header {
    X-Frame-Options "SAMEORIGIN"
    X-Content-Type-Options "nosniff"
    X-XSS-Protection "1; mode=block"
    Referrer-Policy "strict-origin-when-cross-origin"
    Permissions-Policy "geolocation=(), microphone=(), camera=()"
    -Server
}

# Compression
encode zstd gzip
```

**Not:** Caddy kullanmıyorsanız bu dosyaya gerek yok. Traefik kullanıyorsanız Container Labels kullanın (aşağıda).

---

## ⚙️ Config Dosyaları

### 1. `config/database.php`
Veritabanı bağlantısı ve environment variables yönetimi.

```php
<?php
// Veritabanı bağlantısı - Coolify uyumlu

// .env dosyasını yükle (basit parser) - Coolify'de environment variable'lar kullanılır
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

// Helper function: Environment variable'ı getir (Coolify uyumlu)
function getEnvVar($key, $default = null) {
    // Önce getenv() dene (Coolify'de bu kullanılır)
    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }
    // Sonra $_ENV'den dene
    return $_ENV[$key] ?? $default;
}

// Veritabanı ayarları - Coolify environment variable'larından al
define('DB_HOST', getEnvVar('DB_HOST', 'localhost'));
define('DB_PORT', getEnvVar('DB_PORT', '3306'));
define('DB_NAME', getEnvVar('DB_NAME', 'your_database'));
define('DB_USER', getEnvVar('DB_USER', 'root'));
define('DB_PASS', getEnvVar('DB_PASS', ''));

// PDO bağlantısı - Performans için optimize edildi
// Türkçe karakter desteği için UTF-8 charset ayarları
try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO(
        $dsn,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            // Performans optimizasyonları
            PDO::ATTR_PERSISTENT => false, // Connection pooling için false
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ]
    );
    
    // Bağlantı sonrası charset ayarlarını güçlendir (Türkçe karakter desteği için)
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("SET character_set_client = utf8mb4");
    $pdo->exec("SET character_set_connection = utf8mb4");
    $pdo->exec("SET character_set_results = utf8mb4");
    $pdo->exec("SET collation_connection = utf8mb4_unicode_ci");
    
} catch (PDOException $e) {
    // Hata mesajını logla
    error_log("Database Connection Error: " . $e->getMessage());
    error_log("DSN: " . $dsn);
    error_log("User: " . DB_USER);
    
    // Debug mode açıksa detaylı hata göster
    $debug_mode = getEnvVar('DEBUG_MODE', 'false');
    if ($debug_mode === 'true' || $debug_mode === true) {
        die("Veritabanı bağlantısı başarısız: " . $e->getMessage() . "<br>DSN: " . $dsn);
    } else {
        die("Veritabanı bağlantısı başarısız. Lütfen yönetici ile iletişime geçin.");
    }
}
```

**Önemli Noktalar:**
- `getEnvVar()` fonksiyonu hem `getenv()` hem de `$_ENV`'den değer alır (Coolify uyumlu)
- UTF-8 charset ayarları Türkçe karakter desteği için kritik
- Error handling production ve development modları için optimize edilmiş

### 2. `config/config.php`
Genel uygulama ayarları ve session yönetimi.

```php
<?php
// Genel site ayarları - Coolify uyumlu

// Veritabanı bağlantısını dahil et (getEnvVar fonksiyonu burada tanımlı)
require_once __DIR__ . '/database.php';

// Türkçe karakter desteği için UTF-8 encoding ayarları
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}
if (function_exists('mb_http_output')) {
    mb_http_output('UTF-8');
}
if (function_exists('mb_regex_encoding')) {
    mb_regex_encoding('UTF-8');
}
ini_set('default_charset', 'UTF-8');

// Environment mode (production/development)
$app_env = getEnvVar('APP_ENV', 'production');

// Hata raporlama - Debug mode kontrolü
$debug_mode = getEnvVar('DEBUG_MODE', 'false');
$debug_mode = ($debug_mode === 'true' || $debug_mode === true);

if ($app_env === 'development' || $debug_mode) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../logs/php_errors.log');
}

// Timezone
date_default_timezone_set('Europe/Istanbul');

// Session ayarları - Coolify için optimize edildi
session_start([
    'cookie_httponly' => 1,
    'cookie_secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 1 : 0,
    'cookie_samesite' => 'Lax'
]);

// Site sabitleri - Coolify environment variable'larından al
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
define('SITE_URL', getEnvVar('SITE_URL', $protocol . $host));
define('CONTACT_EMAIL', getEnvVar('CONTACT_EMAIL', 'info@yourdomain.com'));
define('UPLOAD_PATH', __DIR__ . '/../assets/uploads/');
define('UPLOAD_URL', SITE_URL . '/assets/uploads/');

// Uploads klasörünü otomatik oluştur (Coolify deploy sonrası için)
$uploadDirs = [
    __DIR__ . '/../assets/uploads/',
    __DIR__ . '/../assets/uploads/blogs/',
    __DIR__ . '/../assets/uploads/certificates/',
    __DIR__ . '/../assets/uploads/services/',
    __DIR__ . '/../assets/uploads/stories/'
];

foreach ($uploadDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
        if (!is_dir($dir)) {
            error_log("Warning: Could not create upload directory: " . $dir);
        }
    }
}

// CSRF Token oluştur
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
```

**Önemli Noktalar:**
- UTF-8 encoding ayarları Türkçe karakter desteği için
- Session ayarları HTTPS için optimize edilmiş
- Upload dizinleri otomatik oluşturulur
- Error handling production ve development modları için

---

## 🛣️ Router Yapılandırması

### `router.php`
Clean URL'ler için PHP router.

```php
<?php
/**
 * PHP Router for Clean URLs
 * Works with Nginx, Caddy, and Traefik
 */

// Config'i yükle (eğer yüklenmemişse)
if (!defined('SITE_URL')) {
    require_once __DIR__ . '/config/config.php';
}

// Request URI'yi al
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH);
$requestPath = rtrim($requestPath, '/');

// Query string'i al
$queryString = $_SERVER['QUERY_STRING'] ?? '';

// Admin panel ve process endpoint'leri direkt geç
if (strpos($requestPath, '/admin/') === 0 ||
    strpos($requestPath, '/process_appointment') === 0 ||
    strpos($requestPath, '/generate_sitemap') === 0 ||
    strpos($requestPath, '/reset_session') === 0) {
    return false; // Let server handle it
}

// Root path - return false to let index.php handle it
if ($requestPath === '' || $requestPath === '/') {
    return false; // Let index.php handle root
}

// Blog detail - /blog/{id}/{slug}
if (preg_match('#^/blog/(\d+)/([a-zA-Z0-9-]+)/?$#', $requestPath, $matches)) {
    $_GET['id'] = $matches[1];
    require_once __DIR__ . '/blog-detail.php';
    return true;
}

// Success story detail - /success-story/{id}/{slug}
if (preg_match('#^/success-story/(\d+)/([a-zA-Z0-9-]+)/?$#', $requestPath, $matches)) {
    $_GET['id'] = $matches[1];
    require_once __DIR__ . '/success-story-detail.php';
    return true;
}

// Clean URL - remove leading slash and try .php file
$phpFile = ltrim($requestPath, '/');
$filePath = __DIR__ . '/' . $phpFile . '.php';

// Check if PHP file exists
if (file_exists($filePath)) {
    require_once $filePath;
    return true;
}

// If not found, return false to let server handle 404
return false;
```

### `index.php` - Router Entegrasyonu

```php
<?php
/**
 * Main Entry Point with Router Support
 * For clean URLs, router.php handles routing
 */

// Router support for clean URLs
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestPath = rtrim($requestPath, '/');

// Static dosyaları kontrol et
if (preg_match('/\.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot|webp|xml|txt|pdf)$/i', $requestPath)) {
    http_response_code(404);
    require_once __DIR__ . '/404.php';
    exit;
}

// Router'ı dene
$routerHandled = require_once __DIR__ . '/router.php';

// Router işlediyse çık
if ($routerHandled === true) {
    exit;
}

// Router işlemediyse normal index.php devam eder
require_once __DIR__ . '/config/config.php';

// ... rest of your index.php code
```

**Önemli Noktalar:**
- Router static dosyaları ve admin paneli bypass eder
- Clean URL'ler otomatik olarak `.php` dosyalarına yönlendirilir
- Özel route'lar (blog, success-story) regex ile handle edilir

---

## 🌐 Web Server Yapılandırması

### Traefik Container Labels (Önerilen)

Coolify'de Traefik kullanıyorsanız, Container Labels bölümüne aşağıdaki label'ları ekleyin:

```yaml
traefik.enable=true
traefik.http.middlewares.redirect-to-https.redirectscheme.scheme=https
traefik.http.middlewares.rewrite-to-index.replacepathregex.regex=^/(?!assets|index\.php|.*\.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot|webp|xml|txt|pdf)).*$
traefik.http.middlewares.rewrite-to-index.replacepathregex.replacement=/index.php
traefik.http.routers.http-0.entryPoints=http
traefik.http.routers.http-0.middlewares=redirect-to-https
traefik.http.routers.http-0.rule=Host(yourdomain.com)
traefik.http.routers.http-0.service=http-0
traefik.http.routers.https-0.entryPoints=https
traefik.http.routers.https-0.middlewares=rewrite-to-index
traefik.http.routers.https-0.rule=Host(yourdomain.com)
traefik.http.routers.https-0.service=https-0
traefik.http.routers.https-0.tls.certresolver=letsencrypt
traefik.http.routers.https-0.tls=true
traefik.http.services.http-0.loadbalancer.server.port=3000
traefik.http.services.https-0.loadbalancer.server.port=3000
```

**Açıklama:**
- `rewrite-to-index`: Clean URL'leri `/index.php`'ye yönlendirir
- `redirect-to-https`: HTTP'yi HTTPS'ye yönlendirir
- `port=3000`: PHP built-in server portu
- `Host(yourdomain.com)`: Kendi domain'inizi yazın

### Caddy Labels (Caddy kullanıyorsanız)

```yaml
caddy_0.encode=zstd gzip
caddy_0.handle_path.0_reverse_proxy={{upstreams 3000}}
caddy_0.handle_path=/*
caddy_0.header=-Server
caddy_0.try_files={path} /index.html /index.php
caddy_0=https://yourdomain.com
caddy_ingress_network=coolify
```

**Not:** Caddy kullanıyorsanız `Caddyfile` dosyası da kullanılabilir (yukarıda örnek var).

---

## 🚀 Coolify Deployment

### 1. Repository'yi Bağlayın
- Coolify'de yeni bir uygulama oluşturun
- Git repository'nizi bağlayın
- Branch seçin (genellikle `main` veya `master`)

### 2. Build Pack Seçin
- **Nixpacks** seçin (otomatik PHP algılama)
- Nixpacks `Procfile` dosyasını otomatik olarak kullanır

### 3. Environment Variables Ekleyin
`.env-example` dosyasındaki tüm değişkenleri Coolify'deki Environment Variables bölümüne ekleyin:

```
DB_HOST=your_database_host
DB_PORT=3306
DB_NAME=your_database_name
DB_USER=your_database_user
DB_PASS=your_database_password
SITE_URL=https://yourdomain.com
...
```

### 4. Web Server Yapılandırması
- **Traefik** kullanıyorsanız: Container Labels ekleyin (yukarıda örnek var)
- **Caddy** kullanıyorsanız: `Caddyfile` dosyasını ekleyin veya Caddy Labels kullanın

### 5. Port Yapılandırması
- Port: `3000` (Procfile'da belirtilen)
- Coolify otomatik olarak bu portu kullanır

### 6. Deploy
- Deploy butonuna tıklayın
- Logları takip edin
- Hata varsa Troubleshooting bölümüne bakın

---

## 🔧 Troubleshooting

### "No available server" Hatası

**Neden:** Web server (Traefik/Caddy) PHP server'ı bulamıyor.

**Çözüm:**
1. `Procfile` dosyasının doğru olduğundan emin olun: `web: php -S 0.0.0.0:3000 -t /app`
2. Container Labels'da port'un `3000` olduğundan emin olun
3. Logları kontrol edin: `[server:info] Server starting on port 3000` mesajını görmelisiniz

### "404 Not Found" Hatası (Clean URL'ler)

**Neden:** Web server clean URL'leri `/index.php`'ye yönlendirmiyor.

**Çözüm:**
1. Traefik kullanıyorsanız: `rewrite-to-index` middleware'inin doğru yapılandırıldığından emin olun
2. Caddy kullanıyorsanız: `Caddyfile`'da `try_files {path} /index.php` satırının olduğundan emin olun
3. `router.php` dosyasının doğru çalıştığından emin olun

### Veritabanı Bağlantı Hatası

**Neden:** Environment variables yüklenmemiş veya yanlış.

**Çözüm:**
1. Coolify'deki Environment Variables bölümünü kontrol edin
2. `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS` değerlerinin doğru olduğundan emin olun
3. Veritabanı servisinin çalıştığından emin olun
4. Debug mode'u açın: `DEBUG_MODE=true` (geçici olarak)

### Türkçe Karakter Sorunları

**Neden:** UTF-8 encoding ayarları eksik.

**Çözüm:**
1. `config/config.php`'de UTF-8 encoding ayarlarının olduğundan emin olun
2. `config/database.php`'de `charset=utf8mb4` kullanıldığından emin olun
3. Veritabanı tablolarının `utf8mb4_unicode_ci` collation kullandığından emin olun

### Session Sorunları

**Neden:** Session ayarları HTTPS için optimize edilmemiş.

**Çözüm:**
1. `config/config.php`'de session ayarlarının doğru olduğundan emin olun:
   ```php
   session_start([
       'cookie_httponly' => 1,
       'cookie_secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? 1 : 0,
       'cookie_samesite' => 'Lax'
   ]);
   ```

### Cache Sorunları (Yeni Resimler Görünmüyor)

**Neden:** Static dosyalar cache'leniyor.

**Çözüm:**
1. Cache-busting için `filemtime()` kullanın:
   ```php
   function imageUrl($path) {
       $filePath = __DIR__ . '/../assets/img/' . $path;
       if (file_exists($filePath)) {
           $timestamp = filemtime($filePath);
           $size = filesize($filePath);
           return '/assets/img/' . $path . '?v=' . $timestamp . '&s=' . $size;
       }
       return '/assets/img/' . $path;
   }
   ```
2. Caddyfile'da query string ile cache bypass ekleyin (yukarıda örnek var)

---

## 📝 Özet Checklist

Deployment öncesi kontrol listesi:

- [ ] `Procfile` dosyası var ve doğru yapılandırılmış
- [ ] `.env-example` dosyası var ve güncel
- [ ] `config/database.php` dosyası `getEnvVar()` fonksiyonunu kullanıyor
- [ ] `config/config.php` dosyası UTF-8 encoding ayarlarını içeriyor
- [ ] `router.php` dosyası var ve clean URL'leri handle ediyor
- [ ] `index.php` router'ı entegre ediyor
- [ ] Coolify'de Environment Variables eklenmiş
- [ ] Container Labels (Traefik) veya Caddyfile (Caddy) yapılandırılmış
- [ ] Port `3000` olarak ayarlanmış
- [ ] Veritabanı bağlantısı test edilmiş
- [ ] Clean URL'ler test edilmiş
- [ ] HTTPS yönlendirmesi çalışıyor
- [ ] Session yönetimi çalışıyor

---

## 🎯 Sonuç

Bu rehber, Coolify'de PHP projelerini deploy etmek için gereken tüm bilgileri içerir. Her dosyanın ne içermesi gerektiğini ve nasıl yapılandırılacağını açıklar. Sorun yaşarsanız Troubleshooting bölümüne bakın.

**Önemli Notlar:**
- Bu rehber genel bir rehberdir ve tüm PHP projelerinde kullanılabilir
- Projenize özel route'ları `router.php`'ye ekleyebilirsiniz
- Environment variables'ı Coolify'de yönetin, `.env` dosyasına gerek yok
- Production'da `DEBUG_MODE=false` yapın

---

**Geliştirici:** Devrim Tuncer - www.devrimtuncer.com

