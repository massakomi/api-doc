export const hashLink = {

  toggleByHash(hash) {
    hash = hash.substring(1);
    hash = decodeURIComponent(hash);

    if (hash) {
      let el = document.querySelector(`[data-group="${hash}"]`)
      if (!el) {
        console.error(`[data-group="${hash}"]`)
        return;
      }
      $('.group, [data-group]').addClass('d-none')
      el.classList.remove('d-none')
      el.nextElementSibling.classList.remove('d-none')

    } else {
      $('.group, [data-group]').removeClass('d-none')
    }
  },

  nav() {
    // Навигация по группам
    $('.nav-link').on('click', (e) => {

      $('.nav-link').removeClass('active')
      $(e.target).addClass('active')

      let url = new URL(e.target.href);
      this.toggleByHash(url.hash)

      /*let navbarHeight = $('.navbar').height() + 30;
      window.scrollTo({
        top: el.offsetTop - navbarHeight,
        left: 0,
        behavior: "smooth"
      });*/
    })

    let hash = location.hash;
    if (hash) {
      this.toggleByHash(hash)
    }
  }
}