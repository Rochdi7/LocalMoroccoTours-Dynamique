// vite.config.js
import { defineConfig } from "file:///C:/Users/Outlaw/Desktop/Projects/LocalMoroccoTours/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Users/Outlaw/Desktop/Projects/LocalMoroccoTours/node_modules/laravel-vite-plugin/dist/index.js";
import { viteStaticCopy } from "file:///C:/Users/Outlaw/Desktop/Projects/LocalMoroccoTours/node_modules/vite-plugin-static-copy/dist/index.js";
var vite_config_default = defineConfig({
  build: {
    manifest: true,
    rtl: true,
    outDir: "public/build/",
    cssCodeSplit: true,
    rollupOptions: {
      output: {
        assetFileNames: (css) => {
          if (css.name.split(".").pop() == "css") {
            return `css/[name].css`;
          } else {
            return "icons/" + css.name;
          }
        },
        entryFileNames: `js/[name].js`
      }
    }
  },
  plugins: [
    laravel({
      input: [
        "resources/scss/landing.scss",
        "resources/scss/style-preset.scss",
        "resources/scss/style.scss",
        "resources/scss/uikit.scss"
      ],
      refresh: true
    }),
    viteStaticCopy({
      targets: [
        {
          src: "resources/plugins",
          dest: "css"
        },
        {
          src: "resources/fonts",
          dest: ""
        },
        {
          src: "resources/images",
          dest: ""
        },
        {
          src: "resources/js",
          dest: ""
        },
        {
          src: "resources/json",
          dest: ""
        }
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxVc2Vyc1xcXFxPdXRsYXdcXFxcRGVza3RvcFxcXFxQcm9qZWN0c1xcXFxMb2NhbE1vcm9jY29Ub3Vyc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxcVXNlcnNcXFxcT3V0bGF3XFxcXERlc2t0b3BcXFxcUHJvamVjdHNcXFxcTG9jYWxNb3JvY2NvVG91cnNcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L1VzZXJzL091dGxhdy9EZXNrdG9wL1Byb2plY3RzL0xvY2FsTW9yb2Njb1RvdXJzL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB7IHZpdGVTdGF0aWNDb3B5IH0gZnJvbSAndml0ZS1wbHVnaW4tc3RhdGljLWNvcHknXG5cbmV4cG9ydCBkZWZhdWx0IGRlZmluZUNvbmZpZyh7XG4gICAgYnVpbGQ6IHtcbiAgICAgICAgbWFuaWZlc3Q6IHRydWUsXG4gICAgICAgIHJ0bDogdHJ1ZSxcbiAgICAgICAgb3V0RGlyOiAncHVibGljL2J1aWxkLycsXG4gICAgICAgIGNzc0NvZGVTcGxpdDogdHJ1ZSxcbiAgICAgICAgcm9sbHVwT3B0aW9uczoge1xuICAgICAgICAgICAgb3V0cHV0OiB7XG4gICAgICAgICAgICAgICAgYXNzZXRGaWxlTmFtZXM6IChjc3MpID0+IHtcbiAgICAgICAgICAgICAgICAgICAgaWYgKGNzcy5uYW1lLnNwbGl0KCcuJykucG9wKCkgPT0gJ2NzcycpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAnY3NzLycgKyBgW25hbWVdYCArICcuY3NzJztcbiAgICAgICAgICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIHJldHVybiAnaWNvbnMvJyArIGNzcy5uYW1lO1xuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgICAgICBlbnRyeUZpbGVOYW1lczogJ2pzLycgKyBgW25hbWVdYCArIGAuanNgLFxuICAgICAgICAgICAgfSxcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgbGFyYXZlbCh7XG4gICAgICAgICAgICBpbnB1dDogW1xuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc2Nzcy9sYW5kaW5nLnNjc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc2Nzcy9zdHlsZS1wcmVzZXQuc2NzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zY3NzL3N0eWxlLnNjc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvc2Nzcy91aWtpdC5zY3NzJyxcbiAgICAgICAgICAgIF0sXG4gICAgICAgICAgICByZWZyZXNoOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICAgICAgdml0ZVN0YXRpY0NvcHkoe1xuICAgICAgICAgICAgdGFyZ2V0czogW1xuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL3BsdWdpbnMnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnY3NzJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvZm9udHMnLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgICAgICBzcmM6ICdyZXNvdXJjZXMvaW1hZ2VzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJydcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2pzJyxcbiAgICAgICAgICAgICAgICAgICAgZGVzdDogJydcbiAgICAgICAgICAgICAgICB9LFxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgc3JjOiAncmVzb3VyY2VzL2pzb24nLFxuICAgICAgICAgICAgICAgICAgICBkZXN0OiAnJ1xuICAgICAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBdLFxuICAgICAgICB9KVxuICAgIF0sXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBb1YsU0FBUyxvQkFBb0I7QUFDalgsT0FBTyxhQUFhO0FBQ3BCLFNBQVMsc0JBQXNCO0FBRS9CLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLE9BQU87QUFBQSxJQUNILFVBQVU7QUFBQSxJQUNWLEtBQUs7QUFBQSxJQUNMLFFBQVE7QUFBQSxJQUNSLGNBQWM7QUFBQSxJQUNkLGVBQWU7QUFBQSxNQUNYLFFBQVE7QUFBQSxRQUNKLGdCQUFnQixDQUFDLFFBQVE7QUFDckIsY0FBSSxJQUFJLEtBQUssTUFBTSxHQUFHLEVBQUUsSUFBSSxLQUFLLE9BQU87QUFDcEMsbUJBQU87QUFBQSxVQUNYLE9BQU87QUFDSCxtQkFBTyxXQUFXLElBQUk7QUFBQSxVQUMxQjtBQUFBLFFBQ0o7QUFBQSxRQUNBLGdCQUFnQjtBQUFBLE1BQ3BCO0FBQUEsSUFDSjtBQUFBLEVBQ0o7QUFBQSxFQUNBLFNBQVM7QUFBQSxJQUNMLFFBQVE7QUFBQSxNQUNKLE9BQU87QUFBQSxRQUNIO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLElBQ2IsQ0FBQztBQUFBLElBQ0QsZUFBZTtBQUFBLE1BQ1gsU0FBUztBQUFBLFFBQ0w7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxRQUNBO0FBQUEsVUFDSSxLQUFLO0FBQUEsVUFDTCxNQUFNO0FBQUEsUUFDVjtBQUFBLFFBQ0E7QUFBQSxVQUNJLEtBQUs7QUFBQSxVQUNMLE1BQU07QUFBQSxRQUNWO0FBQUEsUUFDQTtBQUFBLFVBQ0ksS0FBSztBQUFBLFVBQ0wsTUFBTTtBQUFBLFFBQ1Y7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
