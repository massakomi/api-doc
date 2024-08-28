
import { $ } from './jquery-git.module.min.js'
window.$ = $
import { createApp } from './vue.esm-browser.js'

import { blockMain } from "./components/main.js";
import { blockParams } from "./components/params.js";
import { blockTry } from "./components/try.js";
import { hashLink } from "./hashLink.js";


const Doc = {
  data() {
    return {
      groups: []
    }
  },
  methods: {

  },

  mounted() {
    console.log('mounted')
    let values = $('#doc-app').data('groups')
    this.groups = values;
  },

  updated() {
    hashLink.nav()

    $('.block__main').on('click', function(e) {
      if (e.target.tagName === 'A') {
        return;
      }
      if (!$(this).next().hasClass('block__hidden')) {
        $(this).next().addClass('block__hidden')
      } else {
        $('.block__info').addClass('block__hidden')
        $(this).next().toggleClass('block__hidden')
      }
    })

    // Открываем в модальном окне
    $('.block__main a').on('click', function(e) {
      if (screen.width > 1900) {
        e.preventDefault();
        let left = screen.width - 800 - 100;
        window.open(e.target.href, "api-win", `width=800,height=600,left=${left},top=100`);
      }
    })
  },
}

const app = createApp(Doc)
app.config.compilerOptions.whitespace = 'preserve'

app.component('block-main', blockMain)
app.component('block-params', blockParams)
app.component('block-try', blockTry)

app.mount('#doc-app')

console.log('index')