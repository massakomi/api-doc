export const blockParams = {
  props: ['info'],
  template:
    `<div>
        <div class="desc" v-if="info.desc">{{ info.desc }}<hr /></div>
        <div v-if="info.param">Параметры запроса:</div>
        <div v-for="(td, name) in info.param">
         - <i><b>{{ name }}</b> {{ td[0] }}</i> {{ td[1] }}<br />
        </div>
        
        <div class="text-success">Параметры ответа:</div>
          - status: true (bool)<br />
          - data: данные<br />
          - meta: [] (array)<br />
          
        <div v-if="info.responseField" class="text-primary">Поля данных (data):</div>
        <div v-for="(desc, name) in info.responseField">
        - <b><i>{{ name }}</i></b> {{ desc }}<br/>
        </div>

        <br />
        <div class="text-danger">Параметры ответа при ошибке:</div>
        - status: false (bool)<br />
        - errors: текст ошибки (string)<br />
        - code: 0 (int)<br />
    </div>`
}