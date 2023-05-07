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
        :title="formState.modalTitle"
        :ok-text="formState.modalAction"
        cancel-text="Cancel"
        @ok="onFormOkUpsert"
        @cancel="onFormCancel"
      >
        <a-form ref="formRef" :model="formState" layout="vertical" name="form_in_modal">
          <a-form-item name="id" label="ID">
            <a-input v-model:value="formState.id" :readonly="true" />
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
      <a-tab-pane key="1" tab="Pending">
        <TodoList
          @some-event="callBackUpdateTask"
          @some-event-2="callBackReloadComp"
          prop1="pending"
          :key="keyPending"
        />
      </a-tab-pane>
      <a-tab-pane key="2" tab="Completed">
        <TodoList @some-event="callBackUpdateTask" prop1="completed" :key="keyCompleted" />
      </a-tab-pane>
      <a-tab-pane key="3" tab="All">
        <TodoList @some-event="callBackUpdateTask" prop1="all" />
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
    /* CallBack to open modal and fill tasks fields */
    callBackUpdateTask(data) {
      const { id, title, description } = data
      this.formState = reactive({
        id: id,
        title: title,
        description: description,
        modifier: 'public',
        modalTitle: 'Update Task',
        modalAction: 'Update'
      })

      this.visible = true
    },

    callBackReloadComp() {
      this.keyPending = this.keyPending + 1
      this.keyCompleted = this.keyCompleted + 1
      this.keyAll = this.keyAll + 1
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
    const keyPending = ref(1)
    const keyCompleted = ref(1)
    const keyAll = ref(1)

    /* Initial state form */
    const formState = reactive({
      id: '',
      title: '',
      description: '',
      modifier: 'public',
      modalTitle: 'Add Task',
      modalAction: 'Create'
    })

    /* Send form to insert or update task */
    const onFormOkUpsert = () => {
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
            .then((response) => response.json())
            .then((data) => {
              if (data.code == 200) {
                openNotificationWithIcon('success', 'Task saved', 'The task has been saved')
                visible.value = false
                formRef.value.resetFields()
                keyPending.value = keyPending.value + 1
                console.log(data)
                return
              }

              this.openNotificationWithIcon('error', 'Error', 'There has been an error')
            })
            .catch((error) => {
              openNotificationWithIcon('error', 'Error', 'The task couldnt be added')
              console.error(error)
            })
        })
        .catch((info) => {
          console.log('Validate Failed:', info)
        })
    }

    const onFormCancel = () => {
      formRef.value.resetFields()
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
      keyPending,
      keyCompleted,
      keyAll,
      TodoList,
      activeKey: ref('1'), // Panel init
      size: ref('default'), // Modal size

      /* ::::: Form ::::: */
      formState,
      formRef,
      visible,
      onFormOkUpsert,
      onFormCancel,
      /* ::::: Form ::::: */

      /* ::::: Notifications ::::: */
      openNotificationWithIcon
      /* ::::: Notifications ::::: */
    }
  }
})
</script>
