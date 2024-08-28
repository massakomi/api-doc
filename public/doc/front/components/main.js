export const blockMain = {
  props: ['info', 'method'],
  template:
    `<div class="block__main">
        <div><b>{{ info.title }}</b></div>
        <b>{{ info.requestMethod }} </b>

        <span v-if="info.requestMethod == 'GET'"><a :href="info.url" target="_blank">{{info.url}}</a></span>
        <span v-else>{{info.url}}</span>

        
        <b class="methodName" :title="info.class"><span>-</span> {{ method }}</b>
    </div>`
}