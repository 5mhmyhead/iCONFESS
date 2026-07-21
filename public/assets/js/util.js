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

// page loader
window.addEventListener('load', function () {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.classList.add('hidden');
    }
});