<template>
  <a-row type="flex" justify="center" align="top">
    <div :style="{ textAlign: 'center' }">
      <a-typography-title :level="2">To Do List | Vue.JS</a-typography-title>
    </div>
  </a-row>

  <a-card>
    <!-- ::::: Add Button ::::: -->
    <a-row type="flex" justify="end" align="top">
      <a-button type="primary" @click="visible = true" :size="size">
        Add Task
        <template #icon>
          <PlusOutlined />
        </template>
      </a-button>
      <a-modal
        v-model:visible="visible"
        title="Add new task"
        ok-text="Create"
        cancel-text="Cancel"
        @ok="onOk"
      >
        <a-form ref="formRef" :model="formState" layout="vertical" name="form_in_modal">
          <a-form-item
            name="id"
            label="ID"
          >
            <a-input v-model:value="formState.id" :readonly='true' />
          </a-form-item>
          <a-form-item
            name="title"
            label="Title"
            :rules="[{ required: true, message: 'Please input the title of task!' }]"
          >
            <a-input v-model:value="formState.title" />
          </a-form-item>
          <a-form-item
            name="description"
            label="Description"
            :rules="[{ required: true, message: 'Please input the description of task!' }]"
          >
            <a-textarea v-model:value="formState.description" />
          </a-form-item>
        </a-form>
      </a-modal>
    </a-row>
    <!-- ::::: Add Button ::::: -->

    <a-tabs type="card" v-model:activeKey="activeKey">
      <a-tab-pane key="1" tab="Pending"> Pending </a-tab-pane>
      <a-tab-pane key="2" tab="Completed"> Completed </a-tab-pane>
      <a-tab-pane key="3" tab="All">
        <TodoList @some-event="callback" prop1="completed" prop2="valor2" />
      </a-tab-pane>
    </a-tabs>
  </a-card>
</template>

<script>
import { notification } from 'ant-design-vue'
import { PlusOutlined } from '@ant-design/icons-vue'
import { defineComponent, ref, reactive } from 'vue'

import TodoList from './../components/TodoList.vue'

export default defineComponent({
  methods: {
    callback(data) {

      const { id, title, description } = data;
      this.formState = reactive({
        id: id,
        title: title,
        description: description,
        modifier: 'public'
      })
      this.visible = true

      console.log('parent')
      console.log(data) 
      
    }
  },
  components: {
    TodoList,
    PlusOutlined
  },
  setup() {
    /* ::::: Form ::::: */
    const formRef = ref()
    const visible = ref(false)
    const formState = reactive({
      id: '',
      title: '',
      description: '',
      modifier: 'public'
    })
    const onOk = () => {

      formRef.value
        .validateFields()
        .then((values) => {
          fetch('http://localhost/todo-vuejs.php?resource=upsert', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(values)
          })
            .then((response) => {
              // Manejar la respuesta del servidor
              openNotificationWithIcon('success', 'Task Added', 'The task has been added')
              visible.value = false
              formRef.value.resetFields()
              location.reload()
              console.log(response)
            })
            .catch((error) => {
              // Manejar errores
              openNotificationWithIcon('error', 'Error', 'The task couldnt be added')
              console.error(error)
            })
        })
        .catch((info) => {
          console.log('Validate Failed:', info)
        })
    }
    /* ::::: Form ::::: */

    /* ::::: Notifications ::::: */
    const openNotificationWithIcon = (type, message, description) => {
      notification[type]({
        message: message,
        description: description
      })
    }
    /* ::::: Notifications ::::: */

    return {
      TodoList,
      activeKey: ref('3'),

      /* ::::: Form ::::: */
      formState,
      formRef,
      visible,
      onOk,
      /* ::::: Form ::::: */

      /* ::::: Notifications ::::: */
      openNotificationWithIcon
      /* ::::: Notifications ::::: */
    }
  }
})
</script>
