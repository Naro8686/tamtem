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
                  v-model="post.title"
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
                  v-model="post.slug"
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
              <vue-editor v-model="post.body"></vue-editor>
            </div>
          </div>
        </div>
        <div class="col-md-12 frm-buttons">
          <div class="btn-group">
            <input
                v-if="this.$root.profile.permissions.posts.edit"
                class="btn btn-default"
                type="submit"
                value="Обновить"
            />
            <input
                v-if="this.$root.profile.permissions.posts.delete"
                class="btn btn-danger"
                type="button"
                @click="deletePost"
                value="Удалить"
            />
          </div>
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
  name: "Edit",
  mixins: [ViewMixins],
  components: {
    VueEditor
  },
  data() {
    return {
      post: {
        title: "",
        slug: "",
        body: ""
      },
    };
  },
  mounted() {
    this.getPost();
  },
  methods: {
    getPost() {
      axios
          .get("/admin/api/posts/" + this.$route.params.id)
          .then((resp) => {
            this.post = resp.data.data;
          })
          .catch(this.handleErrorResponse);
    },
    saveForm(event) {
      event.preventDefault();

      axios
          .patch("/admin/api/posts/" + this.$route.params.id, this.post)
          .then((resp) => {
            this.messageCreated();
          })
          .catch(this.handleErrorResponse);
    },
    deletePost() {
      axios.delete("/admin/api/posts/" + this.$route.params.id).then((resp) => {
        this.$router.push({ name: "posts" });
        this.messageDeleted();
      });
    },

  }
}
</script>

<style scoped>

</style>