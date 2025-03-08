// Verifica o tema inicial
function initTheme() {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
        localStorage.theme = 'dark'
        return true
    } else {
        document.documentElement.classList.remove('dark')
        localStorage.theme = 'light'
        return false
    }
}

export { initTheme }
