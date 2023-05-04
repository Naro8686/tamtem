<template>
  <!-- Main content -->
  <section class="content">
    <div class="box">
      <form class="row box-body" @submit="saveForm">
        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['title'] ? 'has-error' : ''
              ]"
            >
              <label for="title">Тема</label>
              <input
                  v-model="title"
                  type="text"
                  class="form-control"
                  id="title"
                  placeholder="Введите тему"
              />
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['slug'] ? 'has-error' : ''
              ]"
            >
              <label for="title">Уникальный фрагмент</label>
              <input
                  v-model="slug"
                  type="text"
                  class="form-control"
                  id="title"
                  placeholder="Введите уникальный фрагмент"
              />
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <div class="col-md-12">
            <div
                :class="[
                'form-group',
                errorsServer['body'] ? 'has-error' : ''
              ]"
            >
              <label for="text_body">Текст</label>
              <vue-editor v-model="body"></vue-editor>
            </div>
          </div>
        </div>
        <div class="col-md-12 frm-buttons">
          <input
              class="btn btn-default pull-right"
              type="submit"
              value="Добавить"
          />
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</template>

<script>
import ViewMixins from "../../mixins/view";
import { VueEditor } from "vue2-editor";
export default {
  name: "Create",
  mixins: [ViewMixins],
  components: {
    VueEditor
  },
  data() {
    return {
      title: "",
      slug: "",
      body: ""
    };
  },


  methods: {
    saveForm(event) {
      event.preventDefault();
      var params = {};
      params.title = this.title;
      params.slug = this.slug;
      params.body = this.body;
      axios
          .post("/admin/api/posts/store", params)
          .then((resp) => {
            this.messageCreated();
          })
          .catch(this.handleErrorResponse);
    }
  }
}
</script>

<style scoped>

</style>