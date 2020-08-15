module.exports = {
  purge: [
    './src/views/**/*.php',
    './public/**/*.js'
  ],
  theme: {
    extend: {
      height: (theme) => ({
        "px-400": "400px",
        "px-500": "500px",
      }),
    },
    container: {
      center: true,
    },
  },
  variants: {
    appearance: ["responsive"],
    backgroundColor: ["responsive", "hover", "focus", "focus-within"],
    borderColor: ["responsive", "hover", "focus", "focus-within"],
  },
  plugins: [],
};
