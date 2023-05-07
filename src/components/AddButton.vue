<template>
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
</template>

<script>
import { notification } from 'ant-design-vue'
import { PlusOutlined } from '@ant-design/icons-vue'
import { defineComponent, ref, reactive } from 'vue'

export default defineComponent({
  
  components: {
    PlusOutlined
  },
  
  
  setup() {
    /* ::::: Form ::::: */
    const formRef = ref()
    const visible = ref(false)
    const formState = reactive({
      title: '',
      description: '',
      modifier: 'public'
    })
    const onOk = () => {
      formRef.value
        .validateFields()
        .then((values) => {
          fetch('http://localhost/todo-vuejs.php?resource=todos', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(values)
          })
            .then((response) => response.json())
            .then((data) => {
              
              // Manejar la respuesta del servidor
              openNotificationWithIcon('success', 'Task Added', 'The task has been added')
              visible.value = false
              formRef.value.resetFields()
              location.reload();
              console.log(data)
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
      /* ::::: Form ::::: */
      formState,
      formRef,
      visible,
      onOk,
      /* ::::: Form ::::: */

      /* ::::: Notifications ::::: */
      openNotificationWithIcon,
      /* ::::: Notifications ::::: */
      size: ref('default') // Modal size
    }
  }
})
</script>
