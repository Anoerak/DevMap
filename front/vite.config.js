import { sveltekit } from '@sveltejs/kit/vite';
import { defineConfig } from 'vite';
import sveltePreprocess from 'svelte-preprocess';
// import mkcert from 'vite-plugin-mkcert';

export default defineConfig({
	plugins: [
		sveltekit({
			preprocess: [
				sveltePreprocess({
					scss: {
						prependData: `@import '$lib/style/style.scss';`
					}
				})
			]
		})
		// mkcert({
		// 	server: {
		// 		https: true
		// 	}
		// })
	],
	css: {
		preprocessorOptions: {
			scss: {
				additionalData: `@import '$lib/style/style.scss';`
			}
		}
	}
});
