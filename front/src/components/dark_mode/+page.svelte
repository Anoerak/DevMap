<script>
	import './_dark_mode.scss';
    import { onMount } from 'svelte';
    import window from 'global';

	const STORAGE_KEY = 'theme';
    const DARK_PREFERENCE = '(prefers-color-scheme: dark)';

    const THEMES = {
        DARK: 'dark',
        LIGHT: 'light',
    };

    const prefersDarkThemes = () => window.matchMedia(DARK_PREFERENCE).matches;
    const preferredTheme = prefersDarkThemes() ? THEMES.DARK : THEMES.LIGHT;
    const currentTheme = localStorage.getItem(STORAGE_KEY) ?? preferredTheme;

    const applyTheme = () => {

        if (currentTheme === THEMES.DARK) {
            document.body.classList.remove(THEMES.LIGHT);
            document.body.classList.add(THEMES.DARK);
        } else {
            document.body.classList.remove(THEMES.DARK);
            document.body.classList.add(THEMES.LIGHT);
        }
    };

    const toggleTheme = () => {
        const stored = localStorage.getItem(STORAGE_KEY);

        if (stored) {
        // clear storage
            localStorage.removeItem(STORAGE_KEY);
        } else {
        // store opposite of preference
            localStorage.setItem(STORAGE_KEY, prefersDarkThemes() ? THEMES.LIGHT : THEMES.DARK);
        }

        // TODO: apply new theme
        applyTheme();
    };

    onMount(() => {
        applyTheme();
        window.matchMedia(DARK_PREFERENCE).addEventListener('change', toggleTheme);
    });
</script>

<style lang="scss">
	@import '../../lib/style/style.scss';
</style>

<input type="checkbox" checked={currentTheme !== THEMES.DARK} on:click={toggleTheme} />
