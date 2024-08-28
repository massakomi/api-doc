export const blockTry = {
  props: ['info'],

  methods: {
    submitForm(e) {
      e.preventDefault()
      let form = e.target;
      $(form).find('.errors').html('')
      $(form).find('.content').html('')
      let params = $(form).serialize()
      $.ajax({
        type: 'POST',
        url: form.action,
        data: $(form).serialize(),
        dataType: 'json',
        success: function(data) {
          console.log(data)
          $(form).find('.content').html(JSON.stringify(data))
        },
        error: function(data) {
          console.log(data.responseJSON)
          $(form).find('.errors').html(data.responseJSON.errors)
        }
      });
    }
  },

  template:
    `<form method="post" class="tryItOut" :action="info.url" @submit="submitForm">
        <div v-for="(td, name) in info.param" class="mb-2">
            <input type="text" value="" :name="name" class="form-control form-control-sm" :title="td[0]" :placeholder="name + ' / ' + td[1]">
        </div>
        <input type="submit" class="btn btn-primary mb-2" value="Отправить" />
        <div class="errors text-danger mb-2"></div>
        <div class="content mb-2"></div>
    </form>`
}