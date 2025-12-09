document.addEventListener("DOMContentLoaded", function(){
    const form = document.getElementById('rs-reservation-form');
    if(form){
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const msgDiv = document.getElementById('rs-res-msg');

const data = new FormData(form);
data.append('action', 'rs_reserve'); // Make sure this matches PHP
fetch('rs_ajax.ajax_url', {
    method: 'POST',
    body: data
})

            .then(res => res.json())
            .then(res => {
                // Check if the expected keys exist
                if(res && typeof res.success !== 'undefined'){
                    if(res.success){
                        msgDiv.innerHTML = `<div style="color:#4caf50; font-weight:bold;">${res.msg}</div>`;
                        form.reset();
                    } else {
                        msgDiv.innerHTML = `<div style="color:#f44336; font-weight:bold;">${res.msg}</div>`;
                    }
                } else {
                    msgDiv.innerHTML = `<div style="color:#f44336; font-weight:bold;">Unexpected response from server</div>`;
                    console.log('AJAX Response:', res);
                }
            })
            .catch(err => {
                msgDiv.innerHTML = `<div style="color:#f44336; font-weight:bold;">AJAX error</div>`;
                console.error(err);
            });
        });
    }
});
