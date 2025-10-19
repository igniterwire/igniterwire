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

## Lifecycle Kullanımı

Bir componentte lifecycle fonksiyonlarını override ederek süreçlere müdahale edebilirsiniz:

```php
class Ornek extends Component
{
	public $count = 0;

	public function beforeMount()
	{
		// Component oluşturulmadan hemen önce çalışır
	}

	public function mount($ilkDeger = 0)
	{
		$this->count = $ilkDeger;
	}

	public function afterMount()
	{
		// Component oluşturulduktan sonra çalışır
	}

	public function updating($property, $value)
	{
		// Herhangi bir property güncellenmeden önce çalışır
	}

	public function updated($property, $value)
	{
		// Herhangi bir property güncellendikten sonra çalışır
	}

	public function updateCount($value)
	{
		// Sadece $count değişkeni güncellendiğinde çalışır
	}
}
```

## Gelişmiş Özellikler
- Lifecycle, validation, event sistemi ve daha fazlası için geliştirme devam ediyor.

## Katkı
Pull request ve issue açabilirsiniz.

