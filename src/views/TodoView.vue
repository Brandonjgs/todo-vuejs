<template>
  <a-row type="flex" justify="center" align="top">
    <div :style="{ textAlign: 'center' }">
      <a-typography-title :level="2">To Do List | Vue.JS</a-typography-title>
    </div>
  </a-row>

  <a-card>
    <!-- ::::: Add Button ::::: -->
    <a-row type="flex" justify="end" align="top">
      <div>
        <a-button type="primary" @click="showModal" :size="size">
          Add Task
          <template #icon>
            <PlusOutlined />
          </template>
        </a-button>
        <a-modal v-model:visible="visible" title="Basic Modal" @ok="handleOk">
          <p>Some contents...</p>
          <p>Some contents...</p>
          <p>Some contents...</p>
        </a-modal>
      </div>
    </a-row>
    <!-- ::::: Add Button ::::: -->

    <a-tabs type="card" v-model:activeKey="activeKey">
      <a-tab-pane key="1" tab="Pending">
        Panel 1 ?????
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

        <!-- ::::: List ::::: -->
        <a-list
          item-layout="vertical"
          size="large"
          :pagination="pagination"
          :data-source="listData"
          :style="{ paddingTop: '20px' }"
        >
          <template #footer> </template>
          <template #renderItem="{ item }">
            <a-list-item key="item.title">
              <template #actions>
                <span v-for="{ type, text } in actions" :key="type">
                  <component v-bind:is="type" style="margin-right: 8px" />
                  {{ text }}
                </span>
              </template>
              <template #extra>
                <a-dropdown>
                  <template #overlay>
                    <a-menu @click="handleMenuClick">
                      <a-menu-item key="1">
                        <CheckOutlined />
                        Completed
                      </a-menu-item>
                      <a-menu-item key="2">
                        <EditOutlined />
                        Edit
                      </a-menu-item>
                      <a-menu-item key="3">
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
                <template #avatar><a-avatar :src="item.avatar" /></template>
              </a-list-item-meta>
              <!-- {{ item.content }} -->
            </a-list-item>
          </template>
        </a-list>
        <!-- ::::: List ::::: -->
      </a-tab-pane>
      <a-tab-pane key="2" tab="Completed">
        Content of Tab Pane 2
        <ul>
          <li v-for="todo in fetchTodos" :key="todo.id">
            {{ todo.title }}
          </li>
        </ul>
      </a-tab-pane>
      <a-tab-pane key="3" tab="All">Content of Tab Pane 3</a-tab-pane>
    </a-tabs>
  </a-card>
</template>

<script>
import {
  PlusOutlined,
  StarOutlined,
  LikeOutlined,
  MessageOutlined,
  DownOutlined,
  HistoryOutlined,
  CheckOutlined,
  EditOutlined,
  DeleteOutlined
} from '@ant-design/icons-vue'
import { defineComponent, ref } from 'vue'

const listData = []
for (let i = 0; i < 23; i++) {
  listData.push({
    href: 'https://www.antdv.com/',
    title: `ant design vue part ${i}`,
    avatar: 'https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png',
    description:
      'Ant Design, a design language for background applications, is refined by Ant UED Team. We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people cre',
    content:
      'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.'
  })
}

export default defineComponent({
  data() {
    return {
      todos: [] // Asegúrate de haber declarado la propiedad "todos" aquí
    }
  },
  components: {
    PlusOutlined,
    StarOutlined,
    LikeOutlined,
    MessageOutlined,
    DownOutlined,
    HistoryOutlined,
    CheckOutlined,
    EditOutlined,
    DeleteOutlined
  },
  mounted() {
    this.fetchTodos()
  },
  methods: {
    fetchTodos() {
      fetch('http://localhost/todo-vuejs.php/todos')
        .then((response) => response.json())
        .then((data) => {
          this.todos = data
          console.log(data);
        })
        .catch((error) => {
          console.error(error)
        })
    }
  },
  setup() {
    const visible = ref(false)
    const showModal = () => {
      visible.value = true
    }
    const handleOk = (e) => {
      console.log(e)
      visible.value = false
    }

    const handleButtonClick = (e) => {
      console.log('click left button', e)
    }
    const handleMenuClick = (e) => {
      console.log('click', e)
    }
    const value = ref('')
    const onSearch = (searchValue) => {
      console.log('use value', searchValue)
      console.log('or use this.value', value.value)
    }

    const pagination = {
      onChange: (page) => {
        console.log(page)
      },
      pageSize: 3
    }

    const actions = [
      {
        type: 'HistoryOutlined',
        text: 'Created: 05-05-2023'
      },
      {
        type: 'HistoryOutlined',
        text: 'Updated: 05-05-2023'
      }
    ]

    return {
      visible,
      showModal,
      handleOk,

      listData,
      pagination,
      actions,

      activeKey: ref('1'),
      size: ref('default'),
      value,
      onSearch,

      handleButtonClick,
      handleMenuClick,
      dataSource: [
        {
          key: '1',
          name: 'Mike',
          age: 32,
          address: '10 Downing Street'
        },
        {
          key: '2',
          name: 'John',
          age: 42,
          address: '10 Downing Street'
        }
      ],

      columns: [
        {
          title: 'Name',
          dataIndex: 'name',
          key: 'name'
        },
        {
          title: 'Age',
          dataIndex: 'age',
          key: 'age'
        },
        {
          title: 'Address',
          dataIndex: 'address',
          key: 'address'
        }
      ]
    }
  }
})
</script>
