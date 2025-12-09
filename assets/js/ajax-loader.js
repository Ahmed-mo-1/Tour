function loadContent(type) {

    const root = document.querySelector("#root");
    fetch(page_loader.ajax_url, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8" },
        body: new URLSearchParams({ action: "load_content", type })
    })
    .then(r => r.json())
    .then(r => {
        if (!r.success) return console.error("Load failed:", r.data);
        if (type === 'home') root.innerHTML = r.data.html;
    })
    .catch(err => console.error("AJAX Error:", err));
}
