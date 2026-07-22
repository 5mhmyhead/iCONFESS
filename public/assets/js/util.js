function getTokenPayload() {
    const token = localStorage.getItem('jwt_token');
    if (!token) return null;
    try {
        const payload = JSON.parse(atob(token.split('.')[1]));
        if (payload.exp * 1000 < Date.now()) {
            localStorage.removeItem('jwt_token');
            document.cookie = 'jwt_token=; path=/; max-age=0';
            return null;
        }
        return payload;
    } catch {
        localStorage.removeItem('jwt_token');
        document.cookie = 'jwt_token=; path=/; max-age=0';
        return null;
    }
}

window.addEventListener('load', function () {
    const loader = document.getElementById('page-loader');
    if (loader) {
        setTimeout(function () {
            loader.classList.add('hidden');
        }, 200); 
    }
});

document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById('search-keyword');

    if (searchInput) {
        searchInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); 
            }
        });
    }
});