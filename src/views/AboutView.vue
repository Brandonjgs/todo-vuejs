<template>
  <a-list item-layout="vertical" size="large" :pagination="pagination" :data-source="listData">
    <template #footer>
      <div>
        <b>ant design vue</b>
        footer part
      </div>
    </template>
    <template #renderItem="{ item }">
      <a-list-item key="item.title">
        <template #actions>
          <span v-for="{ type, text } in actions" :key="type">
            <component :is="type" style="margin-right: 8px" />
            {{ text }}
          </span>
        </template>
        <template #extra>
          <img
            width="272"
            alt="logo"
            src="https://gw.alipayobjects.com/zos/rmsportal/mqaQswcyDLcXyDKnZfES.png"
          />
        </template>
        <a-list-item-meta :description="item.description">
          <template #title>
            <a :href="item.href">{{ item.title }}</a>
          </template>
          <template #avatar><a-avatar :src="item.avatar" /></template>
        </a-list-item-meta>
        {{ item.content }}
      </a-list-item>
    </template>
  </a-list>
</template>
<script>
import { StarOutlined, LikeOutlined, MessageOutlined } from '@ant-design/icons-vue';
import { defineComponent } from 'vue';
const listData = [];
for (let i = 0; i < 23; i++) {
  listData.push({
    href: 'https://www.antdv.com/',
    title: `ant design vue part ${i}`,
    avatar: 'https://joeschmoe.io/api/v1/random',
    description: 'Ant Design, a design language for background applications, is refined by Ant UED Team.',
    content: 'We supply a series of design principles, practical patterns and high quality design resources (Sketch and Axure), to help people create their product prototypes beautifully and efficiently.',
  });
}
export default defineComponent({
  components: {
    StarOutlined,
    LikeOutlined,
    MessageOutlined,
  },
  setup() {
    const pagination = {
      onChange: page => {
        console.log(page);
      },
      pageSize: 3,
    };
    const actions = [{
      type: 'StarOutlined',
      text: '156',
    }, {
      type: 'LikeOutlined',
      text: '156',
    }, {
      type: 'MessageOutlined',
      text: '2',
    }];
    return {
      listData,
      pagination,
      actions,
    };
  },
});
</script>
<!-- <template>
  <a-table :columns="columns" :data-source="data" @change="onChange" />
</template>
<script>
import { defineComponent } from 'vue';
const columns = [{
  title: 'Name',
  dataIndex: 'name',
}, {
  title: 'Chinese Score',
  dataIndex: 'chinese',
  sorter: {
    compare: (a, b) => a.chinese - b.chinese,
    multiple: 3,
  },
}, {
  title: 'Math Score',
  dataIndex: 'math',
  sorter: {
    compare: (a, b) => a.math - b.math,
    multiple: 2,
  },
}, {
  title: 'English Score',
  dataIndex: 'english',
  sorter: {
    compare: (a, b) => a.english - b.english,
    multiple: 1,
  },
}];
const data = [{
  key: '1',
  name: 'John Brown',
  chinese: 98,
  math: 60,
  english: 70,
}, {
  key: '2',
  name: 'Jim Green',
  chinese: 98,
  math: 66,
  english: 89,
}, {
  key: '3',
  name: 'Joe Black',
  chinese: 98,
  math: 90,
  english: 70,
}, {
  key: '4',
  name: 'Jim Red',
  chinese: 88,
  math: 99,
  english: 89,
}];
export default defineComponent({
  setup() {
    return {
      data,
      columns,
      onChange: (pagination, filters, sorter, extra) => {
        console.log('params', pagination, filters, sorter, extra);
      },
    };
  },
});
</script> -->
<!-- <template>
  <a-tabs v-model:activeKey="activeKey" type="card">
    <a-tab-pane key="1" tab="Tab 1">Content of Tab Pane 1</a-tab-pane>
    <a-tab-pane key="2" tab="Tab 2">Content of Tab Pane 2</a-tab-pane>
    <a-tab-pane key="3" tab="Tab 3">Content of Tab Pane 3</a-tab-pane>
  </a-tabs>
</template>
<script>
import { defineComponent, ref } from 'vue';
export default defineComponent({
  setup() {
    return {
      activeKey: ref('1'),
    };
  },
});
</script> -->
<!-- <template>
  <div class="about">
    <h1>This is an about page</h1>
  </div>

  <a-button type="primary">Primary Button</a-button>
  <a-button>Default Button</a-button>
  <a-button type="dashed">Dashed Button</a-button>
  <a-button type="text">Text Button</a-button>
  <a-button type="link">Link Button</a-button>

  <div>
    <a-textarea
      v-model:value="value1"
      placeholder="Autosize height based on content lines"
      auto-size
    />
    <div style="margin: 24px 0" />
    <a-textarea
      v-model:value="value2"
      placeholder="Autosize height with minimum and maximum number of lines"
      :auto-size="{ minRows: 2, maxRows: 5 }"
    />
  </div>


</template>
<script>
import { defineComponent, ref } from 'vue';
export default defineComponent({
  setup() {
    const value1 = ref('');
    const value2 = ref('');
    return {
      value1,
      value2,
    };
  },
});
</script>
<style>
@media (min-width: 1024px) {
  .about {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style> -->
