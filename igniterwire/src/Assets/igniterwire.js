// Basit igniter:click event listener
document.addEventListener('click', function(e) {
    const target = e.target.closest('[igniter\:click]');
    if (target) {
        e.preventDefault();
        const method = target.getAttribute('igniter:click');
        const component = target.closest('[igniter-component]');
        if (component && method) {
            fetch('/igniterwire/handle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    component: component.getAttribute('igniter-component'),
                    method: method,
                    params: {} // Geliştirilebilir
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.html) {
                    component.innerHTML = data.html;
                }
            });
        }
    }
});
