## Quick start

Do you want to test the application quickly, and you do not have an API ready? No problem, you can use the ready-made example in the **examples** folder. The API for this example is available on the internet, so you can connect to it by entering its address in the configuration file.

### Steps

1. Clone Vue CRUD:
``` console
git clone git@github.com:what-crud/vue-crud.git
```
2. Type following commands:
``` console
yarn
:: or
npm install
```
3. Choose one of the following templates:
- `empty`,
- `simple-crud`,
- `sandbox`,
- `crm`,
- `cms`

...and type e.g.:
``` console
yarn load-template simple-crud
:: or
npm run load-template simple-crud
```
4. If you have your own API prepared, modify **src/config/api.js** file.

5. Serve your app:
``` console
yarn serve
:: or
npm run serve
```
6. Your app is already running (probably at http://localhost:8080).

### Usage

The simplest possible code that supports CRUD operations for one table will look something like this:
``` html
<template>
  <div>
    <crud
      :prefix="prefix"
      :path="path"
      :page-title="pageTitle"
      :fields-info="fieldsInfo"
      :details-title="$t('detailsTitle')"
    >
    </crud>
    <alert-box></alert-box>
  </div>
</template>

<script>
  import Crud from '@/utils/crud/components/Crud.vue'
  import AlertBox from "@/utils/app/components/AlertBox.vue";
  export default {
    data() {
      return {
        prefix: 'demo',
        path: 'tasks',
        pageTitle: 'demo.tasks',
      }
    },
    computed: {
      fieldsInfo() {
        return [{
            text: this.$t('fields.id'),
            name: 'id',
            details: false,
          },
          {
            type: 'input',
            column: 'name',
            text: this.$t('fields.name'),
            name: 'name',
            multiedit: false
          },
          {
            type: 'input',
            column: 'description',
            text: this.$t('fields.description'),
            name: 'description',
            required: false
          },
        ]
      },
    },
    components: {
      Crud,
      AlertBox,
    },
    i18n: {
      messages: {
        en: {
          detailsTitle: 'Task',
          fields: {
            id: 'Id',
            name: 'Name',
            description: 'Description'
          }
        }
      }
    },
  }
</script>
```

## API
The application requires a connection with the appropriate API. API can be created in any technology - the condition is its compliance with the Vue CRUD communication specification. If you need to create your API and do not know how to get started, and you don't mind PHP and Laravel, download or clone the <a href="https://github.com/oh-crud/laravel-crud-api" target="_blank">Laravel CRUD API</a> project.


