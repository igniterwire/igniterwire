// igniter:text, igniter:if, igniter:foreach reactive rendering
function renderIgniterDirectives(component) {
    if (!component) return;
    // igniter:text
    component.querySelectorAll('[igniter\\:text]').forEach(el => {
        const key = el.getAttribute('igniter:text');
        if (key && component.__igniterState && key in component.__igniterState) {
            el.textContent = component.__igniterState[key];
        }
    });
    // igniter:if
    component.querySelectorAll('[igniter\\:if]').forEach(el => {
        const expr = el.getAttribute('igniter:if');
        let show = false;
        if (expr && component.__igniterState) {
            try {
                // Sadece değişken adı ise
                show = !!component.__igniterState[expr];
            } catch (e) {}
        }
        el.style.display = show ? '' : 'none';
    });
    // igniter:foreach
    component.querySelectorAll('[igniter\\:foreach]').forEach(el => {
        const arrKey = el.getAttribute('igniter:foreach');
        const template = el.__igniterTemplate || el.innerHTML;
        if (!el.__igniterTemplate) el.__igniterTemplate = template;
        let html = '';
        if (arrKey && component.__igniterState && Array.isArray(component.__igniterState[arrKey])) {
            component.__igniterState[arrKey].forEach((item, i) => {
                html += template.replace(/\{\{\s*item\s*\}\}/g, item).replace(/\{\{\s*index\s*\}\}/g, i);
            });
        }
        el.innerHTML = html;
    });
}

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
                    // State'i backend'den almak için (örnek: window.__igniterState)
                    if (data.state) {
                        component.__igniterState = data.state;
                    }
                    renderIgniterDirectives(component);
                }
                // İlk yüklemede de çalıştır ve state'i yükle
                document.querySelectorAll('[igniter-component]').forEach(component => {
                    const stateAttr = component.getAttribute('data-igniter-state');
                    if (stateAttr) {
                        try {
                            component.__igniterState = JSON.parse(stateAttr);
                        } catch (e) {}
                    }
                    renderIgniterDirectives(component);
                });
            });
        }
    }
});
