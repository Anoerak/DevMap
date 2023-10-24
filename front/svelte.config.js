import adapter from '@sveltejs/adapter-static';
import { vitePreprocess } from '@sveltejs/vite-plugin-svelte';

/** @type {import('@sveltejs/kit').Config} */
const config = {
	preprocess: vitePreprocess(),
	kit: {
		// adapter-auto only supports some environments, see https://kit.svelte.dev/docs/adapter-auto for a list.
		// If your environment is not supported or you settled on a specific environment, switch out the adapter.
		// See https://kit.svelte.dev/docs/adapters for more information about adapters.
		adapter: adapter({
			strict: false,
			fallback: 'index.html'
		})
		// adapter: adapter({
		// 	out: 'build',
		// 	pages: 'build',
		// 	assets: 'build',
		// 	fallback: 'index.html',
		// 	precompress: false,
		// 	strict: true
		// })
	},

	vitePlugin: {
		// This enables compile-time warnings to be
		// visible in the learn.svelte.dev editor
		onwarn: (warning, defaultHandler) => {
			if (
				warning.code === 'css-unused-selector' ||
				warning.code === 'non-top-level-reactive-declaration'
			) {
				return;
			}
			console.log('svelte:warnings:%s', JSON.stringify(warning));
			defaultHandler(warning);
		}
	}
};

export default config;
