<template>
  <div>
    <!-- ::::: Search ::::: -->
    <a-row type="flex" :style="{ paddingTop: '10px' }">
      <a-col :flex="6">
        <a-input-search
          v-model:value="value"
          placeholder="Search task..."
          enter-button
          @search="onSearch"
        />
      </a-col>
    </a-row>
    <!-- ::::: Search ::::: -->

    <!-- ::::: Order By ::::: -->
    <a-row type="flex" justify="end" align="top" :style="{ paddingTop: '10px' }">
      <a-select
        ref="select"
        style="width: 120px"
        v-model:value="value1"
        @change="onSearch"
        placeholder="Order By"
      >
        <a-select-option value="title">Title</a-select-option>
        <a-select-option value="description">Description</a-select-option>
        <a-select-option value="created">Created</a-select-option>
        <a-select-option value="updated">Updated</a-select-option>
      </a-select>
    </a-row>
    <!-- ::::: Order By ::::: -->

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
              {{ item.title }}
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

export default defineComponent({
  data() {
    return {
      todos: []
    }
  },
  mounted() {
    this.onSearch()
  },
  methods: {
    onSearch() {
      fetch('http://localhost/todo-vuejs.php?resource=todosList', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          task_status: this.prop1,
          search_value: this.value,
          order_by: this.value1
        })
      })
        .then((response) => response.json())
        .then((data) => {
          this.todos = data
          console.log(data)
        })
        .catch((error) => {
          console.error(error)
        })
    },

    /* Controlamos el menu de acciones de cada tarea */
    handleMenuClick(e) {
      switch (e.key) {
        /* Marcar como completada */
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

        /* Editar la tarea */
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

        /* Eliminar la tarea */
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

    return {
      value1: ref(null),
      pagination,
      value
    }
  }
})
</script>
