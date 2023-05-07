<template>
  <div>
    <!-- ::::: Search ::::: -->
    <a-row type="flex" :style="{ paddingTop: '10px' }">
      <a-col :flex="6">
        <a-input-search
          v-model:value="value"
          placeholder="input search text"
          enter-button
          @search="onSearch"
        />
      </a-col>
    </a-row>
    <!-- ::::: Search ::::: -->

    <a-list
      item-layout="vertical"
      size="large"
      :pagination="pagination"
      :data-source="todos"
      :style="{ paddingTop: '20px' }"
    >
      <template #footer> </template>
      <template #renderItem="{ item }">
        <a-list-item key="item.title">
          <template #actions>
            <span>
              <HistoryOutlined />
              Created: {{ item.created }}
            </span>
            <span>
              <HistoryOutlined />
              Updated: {{ item.updated }}
            </span>
          </template>
          <template #extra>
            <a-dropdown>
              <template #overlay>
                <a-menu @click="handleMenuClick">
                  <a-menu-item key="1" :id="item.id">
                    <CheckOutlined />
                    Completed
                  </a-menu-item>
                  <a-menu-item key="2" :id="item.id">
                    <EditOutlined />
                    Edit
                  </a-menu-item>
                  <a-menu-item key="3" :id="item.id">
                    <DeleteOutlined />
                    Delete
                  </a-menu-item>
                </a-menu>
              </template>
              <a-button>
                Actions
                <DownOutlined />
              </a-button>
            </a-dropdown>
          </template>
          <a-list-item-meta :description="item.description">
            <template #title>
              <a :href="item.href">{{ item.title }}</a>
            </template>
            <template #avatar
              ><a-avatar
                src="https://lh3.googleusercontent.com/62OzNxLonba70XxMFP3X3dsdNS9lvG2xf5TqfhYDaw9iFn5as9gVSU23ExfCLoZXkMWA=s360-rw"
            /></template>
          </a-list-item-meta>
          <!-- {{ item.content }} -->
        </a-list-item>
      </template>
    </a-list>
  </div>
</template>

<script>
import {
  DownOutlined,
  CheckOutlined,
  EditOutlined,
  DeleteOutlined,
  HistoryOutlined
} from '@ant-design/icons-vue'
import { defineComponent, ref } from 'vue'

/* const listData = []
for (let i = 0; i < 23; i++) {
  listData.push({
    href: 'https://www.antdv.com/',
    title: `ant design vue part ${i}`,
    avatar:
      'https://lh3.googleusercontent.com/62OzNxLonba70XxMFP3X3dsdNS9lvG2xf5TqfhYDaw9iFn5as9gVSU23ExfCLoZXkMWA=s360-rw',
    description:
      'Ant Design, a design language for background applications, is refined by Ant UED Team. We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre',
    content:
      'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.'
  })
} */

export default defineComponent({
  data() {
    return {
      todos: [] // Asegúrate de haber declarado la propiedad "todos" aquí
    }
  },
  mounted() {
    this.fetchTodos()
    this.onSearch()
  },
  methods: {
    fetchTodos() {
      fetch(`http://localhost/todo-vuejs.php?resource=todos&task_status=${this.prop1}`)
        .then((response) => response.json())
        .then((data) => {
          this.todos = data
          console.log(data)
        })
        .catch((error) => {
          console.error(error)
        })
    },

    onSearch(searchValue) {
      this.todos = [...this.todos, { title: '1aaaaa' }]
      console.log(this.todos)
      console.log('use value', searchValue)
      console.log(this.prop1)
      /* this.$emit('someEvent') */
    },

    handleMenuClick(e) {
      console.log('click', e)
      console.log('click', e.item.id)
      console.log('click', e.key)

      switch (e.key) {
        case '1':
          fetch('http://localhost/todo-vuejs.php?resource=completed', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id: e.item.id,
              task_status: 'completed'
            })
          })
            .then((response) => {
              console.log(response)
              location.reload()
            })
            .catch((error) => {
              // Manejar errores
              /* openNotificationWithIcon('error', 'Error', 'The task couldnt be added') */
              console.error(error)
            })
          break

        case '2':
          fetch(`http://localhost/todo-vuejs.php?resource=id`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id: e.item.id
            })
          })
            .then((response) => response.json())
            .then((data) => {
              console.log(data)
              this.$emit('someEvent', data)
            })
            .catch((error) => {
              console.error(error)
            })
          break

        case '3':
          fetch('http://localhost/todo-vuejs.php?resource=delete', {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              id: e.item.id,
              status: 0
            })
          })
            .then((response) => {
              console.log(response)
              location.reload()
            })
            .catch((error) => {
              // Manejar errores
              /* openNotificationWithIcon('error', 'Error', 'The task couldnt be added') */
              console.error(error)
            })
          break
      }
    }
  },
  components: {
    DownOutlined,
    CheckOutlined,
    EditOutlined,
    DeleteOutlined,
    HistoryOutlined
  },
  props: {
    prop1: String,
    prop2: String
  },
  setup() {
    const pagination = {
      onChange: (page) => {
        console.log(page)
      },
      pageSize: 3
    }

    const value = ref('')
    /* const onSearch = (searchValue) => {
      console.log('use value', todos)
      console.log('use value', searchValue)
      console.log('or use this.value', value.value)
    } */

    return {
      pagination,
      value
    }
  }
})
</script>
