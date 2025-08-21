# IgniterWire

CodeIgniter için Livewire benzeri reaktif component paketi.

## Kurulum

1. Composer ile yükleyin:

```bash
composer require igniterwire/igniterwire
```

2. `app/Config/Autoload.php` dosyanıza aşağıdaki helper'ı ekleyin:

```php
public $helpers = ['igniterwire'];
```

3. `igniterwire.js` dosyasını projenize dahil edin:

```html
<script src="/vendor/igniterwire/src/Assets/igniterwire.js"></script>
```

4. Route ekleyin (örnek):

```php
$routes->post('igniterwire/handle', 'IgniterWire\\Controllers\\Handler::handle');
```

## Component Oluşturma

Yeni bir component oluşturmak için spark komutunu kullanın:

```bash
php spark igniterwire:make-component Ornek
```

Bu komut şunları oluşturur:
- `app/IgniterWire/Components/Ornek.php` (component class'ı)
- `app/Views/igniterwire/components/ornek.php` (view dosyası)

## Kullanım

Bir componenti view'da çağırmak için:

```php
<?= igniterwire('ornek') ?>
```

## Event Binding (igniter:click)

HTML içinde:

```html
<button igniter:click="metodAdi">Tıkla</button>
```

## Gelişmiş Özellikler
- Lifecycle, validation, event sistemi ve daha fazlası için geliştirme devam ediyor.

## Katkı
Pull request ve issue açabilirsiniz.
