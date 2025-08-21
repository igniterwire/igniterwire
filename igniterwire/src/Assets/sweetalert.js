// Basit SweetAlert entegrasyonu
window.igniterwireSweetAlert = function(data) {
    if (!data || !data.title) return;
    // SweetAlert2 veya benzeri bir kütüphane ile entegre edilebilir
    alert((data.type ? '['+data.type+'] ' : '') + data.title + (data.text ? ('\n'+data.text) : ''));
};

document.addEventListener('igniterwire:sweetalert', function(e) {
    window.igniterwireSweetAlert(e.detail);
});
