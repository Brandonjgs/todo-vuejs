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
                <a-menu
                  @click="handleMenuClick"
                  :disabled="item.task_status == 'pending' ? false : true"
                >
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
            <template #avatar v-if="item.task_status == 'pending'">
              <a-avatar>
                <template #icon><InfoCircleOutlined /></template>
              </a-avatar>
            </template>

            <template #avatar v-else>
              <a-avatar style="color: #ffff; background-color: #1890ff">
                <template #icon><CheckCircleOutlined /></template>
              </a-avatar>
            </template>
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
  HistoryOutlined,
  InfoCircleOutlined,
  CheckCircleOutlined
} from '@ant-design/icons-vue'
import { defineComponent, ref } from 'vue'
import { notification } from 'ant-design-vue'

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

    /* Handle menu of actions of every task */
    handleMenuClick(e) {
      switch (e.key) {
        /* Mark as completed */
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
            .then((response) => response.json())
            .then((data) => {
              if (data.code == 200) {
                console.log(data)
                this.openNotificationWithIcon(
                  'success',
                  'Task Completed',
                  'The task has been marked as completed'
                )
                this.$emit('someEvent2')
                return
              }

              this.openNotificationWithIcon('error', 'Error', 'There has been an error')
            })
            .catch((error) => {
              // Manejar errores
              this.openNotificationWithIcon('error', 'Error', 'There has been an error')
              console.error(error)
            })
          break

        /* Update task modal */
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

        /* Delete task */
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
            .then((response) => response.json())
            .then((data) => {
              if (data.code == 200) {
                console.log(data)
                this.openNotificationWithIcon(
                  'success',
                  'Task deleted',
                  'The task has been deleted'
                )
                this.$emit('someEvent2')
                return
              }

              this.openNotificationWithIcon('error', 'Error', 'There has been an error')
            })
            .catch((error) => {
              console.error(error)
              this.openNotificationWithIcon('error', 'Error', 'There has been an error')
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
    HistoryOutlined,
    CheckCircleOutlined,
    InfoCircleOutlined
  },
  props: {
    prop1: String,
    prop2: String
  },
  setup() {
    /* ::::: Notifications ::::: */
    const openNotificationWithIcon = (type, message, description) => {
      notification[type]({
        message: message,
        description: description
      })
    }
    /* ::::: Notifications ::::: */

    const pagination = {
      onChange: (page) => {
        console.log(page)
      },
      pageSize: 5
    }

    const value = ref('')

    return {
      value1: ref(null),
      pagination,
      value,

      /* ::::: Notifications ::::: */
      openNotificationWithIcon
      /* ::::: Notifications ::::: */
    }
  }
})
</script>
