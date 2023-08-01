function showLoader() {
    document.getElementById('loader').classList.remove('d-none');
}
function hideLoader() {
    document.getElementById('loader').classList.add('d-none');
}

document.addEventListener('DOMContentLoaded', function() {
    const currentUrl = window.location.href;
    const navLinks = document.querySelectorAll('.side-bar-item');

    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        if (currentUrl.includes(href) || (href.startsWith('#') && currentUrl.endsWith(href))) {
            link.classList.add('active');
        }
    });
});



function successToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mt-5",
        style: {
            background: "#a88beb",
        },
    }).showToast();
}

function errorToast(msg) {
    Toastify({
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        text: msg,
        className: "mt-5",
        style: {
            background: "red",
        },
    }).showToast();
}
