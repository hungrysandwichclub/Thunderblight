// vite.config.js
export default {
    base:"./",
	build: {
		manifest: true,
        outDir: "../public/dist",
        emptyOutDir: true
	},
    server: {
        hmr: {
            host: "localhost",
            port: 3000
        },
        // proxy: {
        //     "/": "http://day-one.test"
        // }
    }
};
