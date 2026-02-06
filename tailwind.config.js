module.exports = {
  content: [
    "./resources/**/*.blade.php",
  ],
  theme: {
    extend: {
      backgroundImage: {
        wood: "url('/assets/img/wood.png')",
      },
      colors: {
        myGreen: '#47602c',
        myYellow: '#d78e15',
        myBrown: '#704429',
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },
  plugins: [],
}