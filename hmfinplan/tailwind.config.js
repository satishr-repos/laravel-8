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
    },
  },
  variants: {
    extend: {
      animation: ['hover'],
      cursor : ['hover'],
    }
  },
  plugins: [],
}
