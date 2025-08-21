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
<script src="/vendor/igniterwire/src/Assets/sweetalert.js"></script>
## Pagination Kullanımı

Component içinde:

```php
use IgniterWire\Pagination;

public $pagination;

public function mount()
{
	$this->pagination = new Pagination($toplamKayit, 10, $this->currentPage ?? 1);
}

public function gotoPage($page)
{
	$this->currentPage = (int)$page;
	$this->pagination->currentPage = $this->currentPage;
	// verileri tekrar yükle
}
```

View dosyasında:

```php
<?= $pagination->links() ?>
```
## SweetAlert Trait Kullanımı

Component içinde:

```php
use IgniterWire\Traits\SweetAlert;

class Ornek extends Component
{
	use SweetAlert;

	public function kaydet()
	{
		// ...
		$this->sweetalert('Başarılı', 'Kayıt başarıyla tamamlandı!', 'success');
	}
}
```

View dosyasında (otomatik tetiklenir):

```php
<?php if ($component->getSweetAlertData()) : ?>
<script>
	document.dispatchEvent(new CustomEvent('igniterwire:sweetalert', { detail: <?= json_encode($component->getSweetAlertData()) ?> }));
</script>
<?php endif; ?>
```
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
