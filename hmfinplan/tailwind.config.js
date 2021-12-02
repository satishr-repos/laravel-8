const colors = require('tailwindcss/colors')

module.exports = {
  purge: [

    './resources/**/*.blade.php',

    './resources/**/*.js',

    './resources/**/*.vue',

  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        'lato'          : ['Lato', 'sans-serif'],
        'merriweather'  : ['Merriweather', 'serif'],
        'montserrat'    : ['Montserrat', 'sans-serif'],
        'noto-serif'    : ['Noto Serif', 'serif'],
        'raleway'       : ['Raleway', 'sans-serif'],
        'roboto'        : ['Roboto', 'sans-serif'],
        'roboto-slab'   : ['Roboto Slab', 'serif'],
        'ubuntu'        : ['Ubuntu', 'sans-serif'],
      },
      
      height: theme => ({
        "screen-80" : "80vh",
        "screen-75" : "75vh",
        "screen/2": "50vh",
        "screen/3": "calc(100vh / 3)",
        "screen/4": "calc(100vh / 4)",
        "screen/5": "calc(100vh / 5)",
      }),

      colors: {
        gray:colors.blueGray,
        teal:colors.teal,
        orange:colors.orange,
        "blue-grey": "#607d8b",
        "blue-grey-50": "#eceff1",
        "blue-grey-100": "#cfd8dc",
        "blue-grey-200": "#b0bec5",
        "blue-grey-300": "#90a4ae",
        "blue-grey-400": "#78909c",
        "blue-grey-500": "#607d8b",
        "blue-grey-600": "#546e7a",
        "blue-grey-700": "#455a64",
        "blue-grey-800": "#37474f",
        "blue-grey-900": "#263238",
        "deep-purple": "#673ab7",
        "deep-purple-50": "#ede7f6",
        "deep-purple-100": "#d1c4e9",
        "deep-purple-200": "#b39ddb",
        "deep-purple-300": "#9575cd",
        "deep-purple-400": "#7e57c2",
        "deep-purple-500": "#673ab7",
        "deep-purple-600": "#5e35b1",
        "deep-purple-700": "#512da8",
        "deep-purple-800": "#4527a0",
        "deep-purple-900": "#311b92",
        "deep-purple-100-accent": "#b388ff",
        "deep-purple-200-accent": "#7c4dff",
        "deep-purple-400-accent": "#651fff",
        "deep-purple-700-accent": "#6200ea",
        "light-blue": "#03a9f4",
        "light-blue-50": "#e1f5fe",
        "light-blue-100": "#b3e5fc",
        "light-blue-200": "#81d4fa",
        "light-blue-300": "#4fc3f7",
        "light-blue-400": "#29b6f6",
        "light-blue-500": "#03a9f4",
        "light-blue-600": "#039be5",
        "light-blue-700": "#0288d1",
        "light-blue-800": "#0277bd",
        "light-blue-900": "#01579b",
        "light-blue-100-accent": "#80d8ff",
        "light-blue-200-accent": "#40c4ff",
        "light-blue-400-accent": "#00b0ff",
        "light-blue-700-accent": "#0091ea",
        "cyan": "#00bcd4",
        "cyan-50": "#e0f7fa",
        "cyan-100": "#b2ebf2",
        "cyan-200": "#80deea",
        "cyan-300": "#4dd0e1",
        "cyan-400": "#26c6da",
        "cyan-500": "#00bcd4",
        "cyan-600": "#00acc1",
        "cyan-700": "#0097a7",
        "cyan-800": "#00838f",
        "cyan-900": "#006064",
        "cyan-100-accent": "#84ffff",
        "cyan-200-accent": "#18ffff",
        "cyan-400-accent": "#00e5ff",
        "cyan-700-accent": "#00b8d4",
        "deep-orange": "#ff5722",
        "deep-orange-50": "#fbe9e7",
        "deep-orange-100": "#ffccbc",
        "deep-orange-200": "#ffab91",
        "deep-orange-300": "#ff8a65",
        "deep-orange-400": "#ff7043",
        "deep-orange-500": "#ff5722",
        "deep-orange-600": "#f4511e",
        "deep-orange-700": "#e64a19",
        "deep-orange-800": "#d84315",
        "deep-orange-900": "#bf360c",
        "deep-orange-100-accent": "#ff9e80",
        "deep-orange-200-accent": "#ff6e40",
        "deep-orange-400-accent": "#ff3d00",
        "deep-orange-700-accent": "#dd2c00",        
      },
    },
  },
  variants: {
    extend: {
      animation: ['hover'],
      transform: ['hover'],
      cursor : ['hover'],
    }
  },
  plugins: [require("@tailwindcss/typography")],
}
