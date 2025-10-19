# IgniterWire Kod İnceleme Raporu

Bu dokümantasyon, IgniterWire projesinde tespit edilen sorunları detaylı olarak listeler.

## 🔴 Kritik Sorunlar

### 1. igniterwire/src/Component.php - Syntax Hatası
**Dosya:** `igniterwire/src/Component.php`  
**Satır:** 59  
**심각度:** CRITICAL  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
```
PHP Parse error: syntax error, unexpected token "{", expecting "function" in line 59
```

Dosyada ciddi yapısal sorunlar tespit edildi:
- Line 59'da orphan (sahipsiz) açılış süslü parantezi
- Duplicate kod blokları (80-189 arası satırlar tamamen tekrarlı)
- Eksik `beforeMount()` metodu
- Dosya geçerli PHP syntax'ına uymuyor ve parse edilemiyor

**Çözüm:**
Dosyayı tamamen yeniden yapılandırmak veya duplicate yapı olduğu için silmek gerekiyor.

---

### 2. Duplicate Dizin Yapısı
**Konum:** Root dizin  
**심각度:** HIGH  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
Projede iki farklı kaynak dizin yapısı mevcut:
- `src/` dizini (düzgün çalışan versiyon)
- `igniterwire/src/` dizini (hatalı duplicate versiyon)

Bu durum:
- Karışıklığa yol açıyor
- Hangi dosyaların kullanıldığı belirsiz
- Bakımı zorlaştırıyor

**Etkilenen Dosyalar:**
- `src/Component.php` vs `igniterwire/src/Component.php`
- `src/helpers.php` vs `igniterwire/src/helpers.php`

**Çözüm:**
`igniterwire/src/` dizinini tamamen kaldırmak veya doğru yapıyı belirlemek.

---

## 🟡 Önemli Sorunlar

### 3. src/Component.php - Eksik beforeMount() Metodu
**Dosya:** `src/Component.php`  
**Satır:** N/A (metod eksik)  
**심각度:** MEDIUM  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
`helpers.php` dosyasında line 9'da `$instance->beforeMount()` çağrılıyor ancak `Component` sınıfında bu metod tanımlı değil.

**Hata Mesajı:**
```php
// helpers.php line 9
$instance->beforeMount(); // Bu metod Component.php'de yok!
```

**Çözüm:**
`Component.php`'ye `beforeMount()` metodunu eklemek:
```php
public function beforeMount()
{
    // override edilebilir
}
```

---

### 4. igniterwire/src/helpers.php - Syntax Hatası
**Dosya:** `igniterwire/src/helpers.php`  
**Satır:** 16-19  
**심각度:** MEDIUM  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
View fonksiyonu çağrısı düzgün kapatılmamış ve return statement yanlış yerleştirilmiş.

**Hatalı Kod:**
```php
// Line 16-19
    $html = view($view, $data);
    // igniter-component attribute'u ile sarmala ve state'i JS için ekle
    $stateJson = htmlspecialchars(json_encode($instance->getViewData()), ENT_QUOTES, 'UTF-8');
    return '<div igniter-component="' . htmlspecialchars($component) . '" data-igniter-state="' . $stateJson . '">' . $html . '</div>';
    }
```

Satır 16'daki view() çağrısından sonraki kodlar fonksiyon dışına çıkmış durumda.

---

### 5. src/Controllers/Handler.php - State Geri Dönüşü Yok
**Dosya:** `src/Controllers/Handler.php`  
**Satır:** 32  
**심각度:** MEDIUM  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
JavaScript kodu `data.state` bekliyor ancak backend JSON response'da state bilgisi gönderilmiyor.

**Mevcut Kod:**
```php
return $this->response->setJSON(['html' => $html]);
```

**Olması Gereken:**
```php
return $this->response->setJSON([
    'html' => $html,
    'state' => $instance->getViewData()
]);
```

JavaScript tarafında (line 63):
```javascript
if (data.state) {
    component.__igniterState = data.state;
}
```

---

## 🟢 Minor Sorunlar

### 6. src/Assets/igniterwire.js - Logic Hatası
**Dosya:** `src/Assets/igniterwire.js`  
**Satır:** 68-78  
**심각度:** LOW  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
Initial render mantığı (satır 68-78) click event handler içinde yer alıyor. Bu kod sayfa ilk yüklendiğinde çalışmalı.

**Hatalı Yapı:**
```javascript
document.addEventListener('click', function(e) {
    // ... click handling code ...
    
    // İlk yüklemede de çalıştır - YANLIŞ YER!
    document.querySelectorAll('[igniter-component]').forEach(component => {
        // ...
    });
});
```

**Çözüm:**
Initial render kodunu DOMContentLoaded event'ine taşımak.

---

### 7. src/Assets/igniterwire.js - Selector Escape Hatası
**Dosya:** `src/Assets/igniterwire.js`  
**Satır:** 5, 12, 24  
**심각度:** LOW  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
CSS selector'larda colon karakteri için yanlış escape kullanımı.

**Mevcut Kod:**
```javascript
component.querySelectorAll('[igniter\\:text]')  // Tek backslash
```

**Not:** JavaScript string'inde `\\:` zaten double backslash oluyor, bu syntax teknik olarak doğru. Ancak okunabilirlik için `[igniter\\:text]` şeklinde yazılabilir.

---

### 8. src/Commands/MakeComponent.php - View Path Tutarsızlığı
**Dosya:** `src/Commands/MakeComponent.php`  
**Satır:** 34  
**심각度:** LOW  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
Template'te view path için doğrudan `$name` değişkeni kullanılıyor, ama view dosyası `strtolower($name)` ile oluşturuluyor.

**Mevcut Kod:**
```php
// Line 34
$template = "... return view('igniterwire/components/$name'); ...";

// Line 41
$viewPath = $viewDir . strtolower($name) . '.php';
```

**Çözüm:**
Template'te de küçük harf kullanmak:
```php
$lowerName = strtolower($name);
$template = "... return view('igniterwire/components/$lowerName'); ...";
```

---

### 9. README.md - Yapısal Düzensizlik
**Dosya:** `README.md`  
**Satır:** 1-40  
**심각度:** LOW  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
Döküman yapısı mantıksız sıralanmış:
1. Lifecycle kullanımı (satır 1-40) - İleri seviye konu
2. Kurulum (satır 41+) - Başlangıç konusu

**Çözüm:**
README'yi yeniden yapılandırmak:
1. Önce proje tanıtımı
2. Kurulum adımları
3. Temel kullanım
4. İleri seviye özellikler (Lifecycle vb.)

---

### 10. composer.json - Tutarsız Helper Tanımı
**Dosya:** `composer.json`  
**Satır:** 13-15  
**심각度:** LOW  
**Durum:** ❌ Açık

**Sorun Açıklaması:**
Autoload bölümünde sadece `src/helpers.php` tanımlı. Eğer `igniterwire/src/helpers.php` kullanılacaksa o da tanımlanmalı veya duplicate dizin yapısı temizlenmeli.

**Mevcut:**
```json
"files": [
    "src/helpers.php"
]
```

---

## Özet

**Toplam Sorun Sayısı:** 10
- 🔴 Kritik: 2
- 🟡 Önemli: 3
- 🟢 Minor: 5

**Öncelikli Çözülmesi Gerekenler:**
1. `igniterwire/src/Component.php` syntax hatası
2. Duplicate dizin yapısını temizleme
3. `beforeMount()` metodu ekleme
4. `igniterwire/src/helpers.php` syntax düzeltme
5. Handler'a state response ekleme

---

**Son Güncelleme:** 2025-10-19  
**İnceleme Yapan:** Automated Code Review
