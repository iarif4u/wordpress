/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
  mode: "jit",
  darkMode: "class",
  content: ["./src/**/*.{html,js,ts,vue}"],
  theme: {
    extend: {
      container: {
        center: true,
      },
      screens: {
        "large-monitor": { min: "2560px" },
        monitor: { min: "2223.98px" },
        "large-laptop": { max: "1535.98px" },
        laptop: { max: "1399.98px" },
        "small-laptop": { max: "1279.98px" },
        "wide-tablet": { max: "1023.98px" },
        tablet: { max: "768.98px" },
        "wide-mobile": { max: "640.98px" },
        mobile: { max: "479.98px" },
      },
      fontFamily: {
        sans: ["DM Sans", ...defaultTheme.fontFamily.sans],
        alfa: ["Pacifico", "cursive"],
        xc: ["x-cloud-icon"],
      },
      dropShadow: {
        button: "0px 2px 2px rgba(0, 40, 132, 0.3)",
      },
      fontSize: {
        xxxs: ".5rem",
        xxs: ".625rem",
        "28px": "1.75rem",
        "40px": "2.5rem",
      },
      colors: {
        primary: {
          light: "#147AFF",
          dark: "#0F70EF",
        },
        secondary: {
          full: "#74778E",
          light: "#C1C9DE",
        },
        light: "#EDF2F8",
        focused: "#D7E6F9",
        dark: "#2A3268",
        danger: "#FC573B",
        warning: "#F8A643",
        failed: "#FD5A78",
        delete: "#FF674F",
        success: {
          light: "#2DC774",
          full: "#32BA7C",
          dark: "#0AA06E",
        },
        mode: {
          base: "#171A30",
          light: "#1D2239",
          secondary: {
            light: "#A8ACBC",
            dark: "#A1A7BA",
          },
          focus: {
            dark: "#232A4E",
            light: "#313A6C",
          },
        },
      },
      ringWidth: {
        1: "0.0625rem",
        2: "0.125rem",
      },
      ringOffsetWidth: {
        3: "0.1725rem",
      },
      borderWidth: {
        1: "0.0625rem",
        2: "0.125rem",
        3: "0.1875rem",
        6: "0.375rem",
      },
      borderRadius: {
        "10px": "0.625rem",
        "20px": "1.75rem",
        "25px": "1.5625rem",
      },
      spacing: {
        "2px": "0.125rem",
        "10px": "0.625rem",
        "15px": "0.9375rem",
        "20px": "1.25rem",
        "25px": "1.5625rem",
        "30px": "1.875rem",
        "40px": "2.5rem",
        "50px": "3.125rem",
        "60px": "3.75rem",
        "100px": "6.25rem",
        "150px": "9.375rem",
        "250px": "15.625rem",
        "400px": "28.5rem",
      },
      maxWidth: {
        "356px": "22.25rem",
        "450px": "28.125rem",
        "400px": "25rem",
        "590px": "36.875rem",
        "850px": "53.125rem",
        "890px": "55.625rem",
        "1050px": "65.625rem",
        "1120px": "70rem",
        "1350px": "84.375rem",
        "2560px": "142.2225rem",
      },
      minWidth: {
        "2px": "0.125rem",
        "15px": "0.9375rem",
        "20px": "1.25rem",
        "25px": "1.5625rem",
        "30px": "1.875rem",
        "40px": "2.5rem",
        "50px": "3.125rem",
        "60px": "3.75rem",
        "100px": "6.25rem",
      },
      minHeight: {
        "2px": "0.125rem",
        "15px": "0.9375rem",
        "20px": "1.25rem",
        "25px": "1.5625rem",
        "30px": "1.875rem",
        "40px": "2.5rem",
        "50px": "3.125rem",
        "60px": "3.75rem",
        "70px": "4.375rem",
        "100px": "6.25rem",
      },
      inset: {
        "10/12": "83.333333%",
      },
      divideWidth: {
        DEFAULT: "0.0625rem",
        1: "0.0625rem",
        2: "0.125rem",
      },
      zIndex: {
        1: "1",
        dropdown: "1000",
        "modal-backdrop": "9999",
        modal: "10000",
        backdrop: "99999",
        sidenote: "100000",
        header: "1000000",
      },
      transitionProperty: {
        switch:
          "color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, " +
            "transform, filter, backdrop-filter, transform, left, right",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [require("autoprefixer")],
};
